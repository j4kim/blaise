<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function update(ServiceCategory $category, Request $request)
    {
        $category->forceFill($request->all())->save();
        return $category;
    }

    public function delete(ServiceCategory $category)
    {
        $category->delete();
        return $category;
    }
}
