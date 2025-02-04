<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function show(Client $client)
    {
        $client->load('lastVisits.sales');
        return [
            ...$client->toArray(),
            'title' => $client->getTitle(),
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
        $qb = Client::query();
        $words = explode(" ", $query);
        foreach ($words as $word) {
            $qb->where(
                function (Builder $qb) use ($word) {
                    $qb->where("first_name", "like", "$word%")
                        ->orWhere("last_name", "like", "$word%");
                }
            );
        }
        return $qb->orderBy('updated_at', 'desc')
            ->select("id", "first_name", "last_name")
            ->take(5)
            ->get();
    }

    public function createFromQuery(string $query)
    {
        $exploded = explode(" ", $query);
        return Client::forceCreate([
            'first_name' => ucfirst($exploded[0]),
            'last_name' => @ucfirst($exploded[1]),
        ]);
    }
}
