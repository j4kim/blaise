<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Client;
use App\Models\Service;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function store(Client $client)
    {
        return $client->visits()->forceCreate([
            'visit_date' => now(),
        ])->fresh();
    }

    public function validate(Visit $visit)
    {
        $visit->billed = $visit->total;
        $visit->save();
        $visit->client()->touch();
        return $visit;
    }

    public function destroy(Visit $visit)
    {
        $visit->sales()->delete();
        return $visit->delete();
    }

    public function addService(Visit $visit, Service $service)
    {
        $visit->sales()->forceCreate([
            'base_price' => $service->price,
            'price_charged' => $service->price,
            'quantity' => 1,
            'type' => 'service',
            'service_id' => $service->id,
            'label' => $service->label,
        ]);
        return $visit->load('sales')->append('total');
    }

    public function addArticle(Visit $visit, Article $article)
    {
        $visit->sales()->forceCreate([
            'base_price' => $article->retail_price,
            'price_charged' => $article->retail_price,
            'quantity' => 1,
            'type' => 'article',
            'article_id' => $article->id,
            'label' => $article->label,
        ]);
        return $visit->load('sales')->append('total');
    }
}
