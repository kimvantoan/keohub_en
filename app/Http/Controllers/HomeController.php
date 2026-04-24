<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $allowedLeagues = [
            'PL' => 'Premier League',
            'PD' => 'La Liga',
            'SA' => 'Serie A',
            'BL1' => 'Bundesliga',
            'FL1' => 'Ligue 1',
        ];

        // Ensure default fallback is safe
        $currentLeagueCode = $request->query('league', 'PL');
        if (!array_key_exists($currentLeagueCode, $allowedLeagues)) {
            $currentLeagueCode = 'PL';
        }

        $currentLeagueName = $allowedLeagues[$currentLeagueCode];
        $cacheKey = "football_standings_{$currentLeagueCode}";

        // Get from cache first
        $standings = Cache::get($cacheKey);

        // If not in cache or cached value is empty, fetch from API
        if (empty($standings)) {
            $apiToken = env('FOOTBALL_DATA_API_TOKEN');
            
            if (empty($apiToken)) {
                Log::warning('FOOTBALL_DATA_API_TOKEN is missing in .env');
                $standings = [];
            } else {
                try {
                    // Fetch standings from football-data.org dynamically
                    $response = Http::withHeaders([
                        'X-Auth-Token' => $apiToken,
                    ])->get("https://api.football-data.org/v4/competitions/{$currentLeagueCode}/standings");

                    if ($response->successful()) {
                        $json = $response->json();
                        
                        if (isset($json['standings'])) {
                            foreach ($json['standings'] as $standing) {
                                if ($standing['type'] === 'TOTAL') {
                                    // Get all teams in the standings
                                    $standings = $standing['table'];
                                    
                                    // Only cache if we actually got data
                                    if (!empty($standings)) {
                                        Cache::put($cacheKey, $standings, 3600);
                                    }
                                    break;
                                }
                            }
                        }
                    } else {
                        Log::error("Football API Error for {$currentLeagueCode}: " . $response->body());
                    }
                } catch (\Exception $e) {
                    Log::error("Football API Exception for {$currentLeagueCode}: " . $e->getMessage());
                }
            }
            
            // Fallback for when fetching fails and no cache exists
            if (!isset($standings)) {
                $standings = [];
            }
        }

        if ($request->ajax()) {
            $html = view('partials.standings', compact('standings', 'currentLeagueCode', 'currentLeagueName', 'allowedLeagues'))->render();
            return response()->json([
                'html' => $html,
                'leagueName' => $currentLeagueName,
                'leagueCode' => $currentLeagueCode
            ]);
        }

        return view('welcome', compact('standings', 'currentLeagueCode', 'currentLeagueName', 'allowedLeagues'));
    }
}
