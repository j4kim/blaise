<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return ServiceCategory::with('services')->orderBy('sort_order')->get();
    }

    public function update(Service $service, Request $request)
    {
        $service->forceFill($request->all())->save();
        return $service;
    }

    public function delete(Service $service)
    {
        $service->delete();
        return $service;
    }
}
