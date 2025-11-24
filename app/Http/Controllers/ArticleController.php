<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);
        
        return view('pages.articles', compact('articles'));
    }

    /**
     * Display the specified article.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Track article view
        $article->increment('views_count');

        // Get related articles from the same category
        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->limit(3)
            ->get();

        return view('pages.article-detail', compact('article', 'relatedArticles'));
    }

    /**
     * Track article view for AJAX requests
     */
    public function trackView($id)
    {
        $article = Article::findOrFail($id);
        $article->increment('views_count');
        
        return response()->json(['success' => true]);
    }
}