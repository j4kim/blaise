<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\TechnicalSheet;
use App\Models\Visit;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function show(Client $client)
    {
        $client
            ->loadCount('visits')
            ->load('lastVisits.sales')
            ->loadCount('technicalSheets')
            ->load('lastTechnicalSheets');
        return [
            ...$client->toArray(),
            'currentVisit' => $client->getCurrentVisit(),
        ];
    }

    public function update(Client $client, Request $request)
    {
        $client->forceFill($request->all())->save();
        return $client;
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

    public function index(Request $request)
    {
        $query = Client::withCount('visits');
        if ($request->sortField) {
            $query->orderBy($request->sortField, $request->sortOrder);
        }
        if ($request->search) {
            $query->search($request->search);
        }
        if ($request->filter === 'trashed') {
            $query->onlyTrashed();
        } else if ($request->filter === 'all') {
            $query->withTrashed();
        }
        return $query->paginate();
    }

    public function details(Client $client)
    {
        return $client;
    }

    public function visits(int $client)
    {
        return Visit::where('client_id', $client)
            ->withTrashed()
            ->whereNotNull('billed')
            ->orderBy('visit_date', 'desc')
            ->get();
    }

    public function sheets(int $client)
    {
        return TechnicalSheet::where('client_id', $client)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        return Client::forceCreate($request->all());
    }

    public function delete(Client $client)
    {
        $client->delete();
        return $client->fresh();
    }
}
