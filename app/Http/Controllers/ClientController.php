<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::withTrashed()->withCount('visits');
        if ($request->sortField) {
            $query->orderBy($request->sortField, $request->sortOrder);
        }
        if ($request->filter) {
            $query->search($request->filter);
        }
        return $query->paginate();
    }

    public function show(Client $client)
    {
        $client->load('lastVisits.sales')->append('title');
        return [
            ...$client->toArray(),
            'currentVisit' => $client->getCurrentVisit(),
        ];
    }

    public function update(Client $client, Request $request)
    {
        $client->forceFill($request->all())->save();
        return $client->append('title');
    }

    public function search(Request $request, string $query)
    {
        return Client::search($query)
            ->orderBy('updated_at', 'desc')
            ->select("id", "first_name", "last_name")
            ->take(5)
            ->get();
    }

    public function createFromQuery(string $query)
    {
        $exploded = explode(" ", $query, 2);
        return Client::forceCreate([
            'first_name' => ucfirst($exploded[0]),
            'last_name' => @ucfirst($exploded[1]),
        ]);
    }

    // Admin routes

    public function details(Client $client)
    {
        return $client->append('title');
    }
}
