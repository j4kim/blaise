<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Line;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::with('line', 'brand')->withCount('sales')->orderBy('sort_order')->get();
    }

    public function brands()
    {
        return Brand::withCount('articles')->orderBy('name')->get();
    }

    public function lines()
    {
        return Line::withCount('articles')->orderBy('name')->get();
    }

    public function updateArticle(Article $article, Request $request)
    {
        $article->forceFill($request->all())->save();
        return $article;
    }

    public function createArticle(Request $request)
    {
        return Article::forceCreate($request->all());
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
        return $article;
    }

    public function deleteBrand(Brand $brand)
    {
        $brand->delete();
        return $brand;
    }

    public function deleteLine(Line $line)
    {
        $line->delete();
        return $line;
    }
}
