<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index()
    {
        return Line::withCount('articles')->orderBy('name')->get();
    }

    public function update(Line $line, Request $request)
    {
        $line->forceFill($request->all())->save();
        return $line->loadCount('articles');
    }

    public function create(Request $request)
    {
        $line = Line::forceCreate($request->all());
        return $line->loadCount('articles');
    }

    public function delete(Line $line)
    {
        $line->delete();
        return $line;
    }
}
