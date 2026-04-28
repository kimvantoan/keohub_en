<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // Get the latest 5 articles for the top section (1 big, 4 small)
        $topArticles = Article::with('categories')
            ->where('is_published', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        // Capture IDs of top articles to exclude from latest news if top section is shown
        $topIds = $topArticles->count() >= 5 ? $topArticles->pluck('id')->toArray() : [];

        // Get the next latest articles for the main column (LATEST NEWS)
        $latestNews = Article::with('categories')
            ->where('is_published', true)
            ->whereNotIn('id', $topIds)
            ->latest('published_at')
            ->paginate(20);

        // If it's an AJAX request (e.g., Load More button), return only the partial HTML and next page URL
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.latest_news_items', compact('latestNews'))->render(),
                'next_url' => $latestNews->nextPageUrl()
            ]);
        }

        // Get a specific category for the right sidebar (e.g., MARKET NEWS).
        // Since we don't know exact names, we just get a random category that has articles, or just pick the first one.
        $sidebarCategory = Category::with(['articles' => function ($query) {
            $query->where('is_published', true)
                  ->latest('published_at')
                  ->take(5);
        }])->has('articles')->first();

        return view('news', compact('topArticles', 'latestNews', 'sidebarCategory'));
    }

    public function show($slug)
    {
        $article = Article::with('categories')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get related articles from the same categories
        $categoryIds = $article->categories->pluck('id');
        $relatedArticles = Article::whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('article', compact('article', 'relatedArticles'));
    }
}
