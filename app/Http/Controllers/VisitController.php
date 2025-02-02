<?php

namespace App\Http\Controllers;

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

    public function destroy(Visit $visit)
    {
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
}
