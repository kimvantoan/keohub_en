<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FixturesController extends Controller
{
    public function index(Request $request)
    {
        // 1. Determine Selected Date
        // User can click ?date=2026-04-20
        $today = Carbon::today();

        $selectedDateStr = $request->query('date', $today->format('Y-m-d'));

        try {
            $selectedDate = Carbon::parse($selectedDateStr);
        } catch (\Exception $e) {
            $selectedDate = $today;
        }

        // 2. Generate the Array of Dates for the Carousel (3 days before, 3 days after)
        $datesSlider = collect();
        for ($i = -3; $i <= 3; $i++) {
            $date = $selectedDate->copy()->addDays($i);
            $datesSlider->push([
                'date' => $date->format('Y-m-d'),
                'day' => strtoupper($date->format('D')),
                'dayNumber' => $date->format('d'),
                'isToday' => $date->format('Y-m-d') === $today->format('Y-m-d'),
                'isSelected' => $date->format('Y-m-d') === $selectedDate->format('Y-m-d')
            ]);
        }

        // 3. Optional: Filter by Competition
        // We will default to showing all available in the response if none is selected
        $selectedComp = $request->query('comp', 'all');

        // 4. Fetch Matches from API (3-day window to ensure plenty of matches)
        $startDate = $selectedDate->copy()->subDays(1)->format('Ymd');
        $endDate = $selectedDate->copy()->addDays(1)->format('Ymd');
        $cacheKey = "fixtures_espn_pool_{$startDate}_{$endDate}";
        $matches = Cache::get($cacheKey);

        if (empty($matches)) {
            // Determine dynamic Cache TTL
            $todayStr = Carbon::today()->format('Ymd');
            if ($startDate <= $todayStr && $endDate >= $todayStr) {
                // Window contains today (live matches possible) -> Cache for 5 minutes
                $cacheTtl = 300; 
            } elseif ($endDate < $todayStr) {
                // Window entirely in the past -> Cache for 24 hours
                $cacheTtl = 86400; 
            } else {
                // Window entirely in the future -> Cache for 1 hour
                $cacheTtl = 3600; 
            }

            try {
                $datesParam = "{$startDate}-{$endDate}";
                $responses = Http::pool(fn ($pool) => [
                    $pool->get("https://site.api.espn.com/apis/site/v2/sports/soccer/eng.1/scoreboard", ['dates' => $datesParam]),
                    $pool->get("https://site.api.espn.com/apis/site/v2/sports/soccer/esp.1/scoreboard", ['dates' => $datesParam]),
                    $pool->get("https://site.api.espn.com/apis/site/v2/sports/soccer/ger.1/scoreboard", ['dates' => $datesParam]),
                    $pool->get("https://site.api.espn.com/apis/site/v2/sports/soccer/ita.1/scoreboard", ['dates' => $datesParam]),
                    $pool->get("https://site.api.espn.com/apis/site/v2/sports/soccer/fra.1/scoreboard", ['dates' => $datesParam]),
                    $pool->get("https://site.api.espn.com/apis/site/v2/sports/soccer/uefa.champions/scoreboard", ['dates' => $datesParam]),
                    $pool->get("https://site.api.espn.com/apis/site/v2/sports/soccer/uefa.europa/scoreboard", ['dates' => $datesParam]),
                ]);

                $matches = [];
                foreach ($responses as $response) {
                    if ($response instanceof \Exception) {
                        Log::error('ESPN API Exception Fixtures Pool: ' . $response->getMessage());
                        continue;
                    }
                    if ($response->successful()) {
                        $json = $response->json();
                        if (isset($json['events'])) {
                            $matches = array_merge($matches, $json['events']);
                        }
                    } else {
                        Log::error('ESPN API Error Fixtures Pool: ' . $response->body());
                    }
                }

                if (!empty($matches)) {
                    Cache::put($cacheKey, $matches, $cacheTtl);
                }
            } catch (\Exception $e) {
                Log::error('ESPN API Exception Fixtures: ' . $e->getMessage());
                $matches = [];
            }
        }

        // 5. Group matches by Competition for the UI
        $groupedMatches = [];

        $baseLeagues = [
            'english-premier-league' => ['name' => 'Premier League', 'short' => 'EN'],
            'laliga' => ['name' => 'La Liga', 'short' => 'ES'],
            'german-bundesliga' => ['name' => 'Bundesliga', 'short' => 'DE'],
            'italian-serie-a' => ['name' => 'Serie A', 'short' => 'IT'],
            'ligue-1' => ['name' => 'Ligue 1', 'short' => 'FR'],
            'uefa-champions-league' => ['name' => 'Champions League', 'short' => 'C1'],
            'uefa-europa-league' => ['name' => 'Europa League', 'short' => 'C2']
        ];

        $availableCompetitions = [];
        foreach ($baseLeagues as $code => $data) {
            $availableCompetitions[$code] = [
                'name' => $data['name'],
                'code' => $code,
                'short' => $data['short']
            ];
        }

        foreach ($matches as $match) {
            $slug = $match['season']['slug'] ?? 'other-competition';
            $uid = $match['uid'] ?? '';

            $matchedBaseCode = null;
            
            // ESPN API doesn't use standard slugs for UEFA competitions in the all/scoreboard endpoint
            if (str_contains($uid, '~l:775~') || str_ends_with($slug, 'uefa.champions') || str_ends_with($slug, 'uefa-champions-league')) {
                $matchedBaseCode = 'uefa-champions-league';
            } elseif (str_contains($uid, '~l:776~') || str_ends_with($slug, 'uefa.europa') || str_ends_with($slug, 'uefa-europa-league')) {
                $matchedBaseCode = 'uefa-europa-league';
            } else {
                foreach (array_keys($baseLeagues) as $allowed) {
                    if (str_ends_with($slug, $allowed)) {
                        $matchedBaseCode = $allowed;
                        break;
                    }
                }
            }

            if (!$matchedBaseCode) {
                continue;
            }

            $compName = $baseLeagues[$matchedBaseCode]['name'];
            $compCode = $matchedBaseCode;

            // Filter if user clicked a specific competition
            if ($selectedComp !== 'all' && $compCode !== $selectedComp) {
                continue;
            }

            // Group them
            if (!isset($groupedMatches[$compName])) {
                $groupedMatches[$compName] = [
                    'emblem' => null,
                    'matches' => []
                ];
            }
            $groupedMatches[$compName]['matches'][] = $match;
        }

        // Sort matches by date within each group
        foreach ($groupedMatches as $compName => &$group) {
            usort($group['matches'], function($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });
        }
        unset($group);

        return view('match', compact(
            'datesSlider',
            'groupedMatches',
            'availableCompetitions',
            'selectedDate',
            'selectedComp'
        ));
    }
}
