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
}
