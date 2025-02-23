<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Visit;
use Illuminate\Http\Request;

class ClientController extends Controller
{
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
        return $client->append('title');
    }

    public function visits(int $client)
    {
        return Visit::where('client_id', $client)
            ->whereNotNull('billed')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        return Client::forceCreate($request->all());
    }

    public function delete(Client $client)
    {
        $client->delete();
        return $client->fresh()->append('title');
    }
}
