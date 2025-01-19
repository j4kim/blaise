<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function show(Client $client)
    {
        return $client;
    }

    public function search(Request $request, string $query)
    {
        return Client::where("first_name", "like", "%$query%")
            ->orWhere("last_name", "like", "%$query%")
            ->get();
    }
}
