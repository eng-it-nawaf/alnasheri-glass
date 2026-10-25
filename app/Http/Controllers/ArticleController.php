<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->latest()
            ->paginate(9);

        return view('frontend.articles.index', compact('articles'));
    }

    public function show(string $slug): View
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->firstOrFail();

        // زيادة عدد المشاهدات بشكل ذري داخل قاعدة البيانات.
        $article->increment('views_count');

        return view('frontend.articles.show', [
            'article' => $article,
        ]);
    }
}