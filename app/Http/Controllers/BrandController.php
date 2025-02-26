<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return Brand::withCount('articles')->orderBy('name')->get();
    }

    public function update(Brand $brand, Request $request)
    {
        $brand->forceFill($request->all())->save();
        return $brand;
    }

    public function create(Request $request)
    {
        return Brand::forceCreate($request->all());
    }

    public function delete(Brand $brand)
    {
        $brand->delete();
        return $brand;
    }
}
