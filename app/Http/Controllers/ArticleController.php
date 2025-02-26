<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::with('line', 'brand')->withCount('sales')->orderBy('sort_order')->get();
    }

    public function update(Article $article, Request $request)
    {
        $article->forceFill($request->all())->save();
        return $article;
    }

    public function create(Request $request)
    {
        return Article::forceCreate($request->all());
    }

    public function delete(Article $article)
    {
        $article->delete();
        return $article;
    }
}
