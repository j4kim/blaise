<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
}
