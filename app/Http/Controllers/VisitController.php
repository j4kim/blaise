<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Client;
use App\Models\Sale;
use App\Models\Service;
use App\Models\TechnicalSheet;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function currents()
    {
        return Visit::with('client')
            ->whereHas('client')
            ->orderBy('visit_date')
            ->whereNull('billed')
            ->get();
    }

    public function store(Client $client)
    {
        return $client->visits()->forceCreate([
            'visit_date' => now(),
        ])->fresh();
    }

    public function replicate(Client $client, Visit $originalVisit)
    {
        $current = $client->getCurrentVisit();
        if (!$current) {
            $current = $client->visits()->forceCreate([
                'visit_date' => now(),
            ]);
        }
        foreach ($originalVisit->sales as $sale) {
            $current->sales()->save($sale->replicate(['visit_id']));
        }
        $current->load('sales');
        return $current->append('subtotal');
    }

    public function update(Visit $visit, Request $request)
    {
        $visit->visit_date = $request->visit_date;
        $visit->save();
        return $visit->load('sales')->append('subtotal');
    }

    public function validate(Visit $visit, Request $request)
    {
        $visit->forceFill($request->except([
            "email_changed",
            "client_email",
        ]));
        $visit->billed = $visit->total;
        $visit->save();
        $visit->client()->touch();
        $visit->sales()->where('type', 'article')->with('article')->each(function (Sale $sale) {
            $art = $sale->article;
            $art->stock = $art->stock - $sale->quantity;
            $art->save();
        });
        if ($request->send_by_email) {
            if ($request->email_changed) {
                $visit->client()->update(['email' => $request->client_email]);
            }
            $visit->sendEmail();
        }
        return $visit;
    }

    public function destroy(Visit $visit)
    {
        $visit->sales()->forceDelete();
        return $visit->forceDelete();
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
        return $visit->load('sales')->append('subtotal');
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
        return $visit->load('sales')->append('subtotal');
    }

    public function addSale(Visit $visit, Request $request)
    {
        $sale = $visit->sales()->forceCreate([
            'price_charged' => $request->price_charged,
            'type' => $request->type,
            'label' => $request->label,
        ]);
        return [
            'visit' => $visit->load('sales')->append('subtotal'),
            'sale' => $sale,
        ];
    }

    public function updateSale(Visit $visit, Sale $sale, Request $request)
    {
        $sale->price_charged = $request->price_charged;
        $sale->label = $request->label;
        $sale->notes = $request->notes;
        if ($sale->type === 'article') {
            $sale->base_price = $request->base_price;
            $sale->quantity = $request->quantity;
            $sale->computeLabel();
        }
        $sale->save();
        $visit->load('sales');
        return $visit->append('subtotal');
    }

    public function addDiscount(Visit $visit, Request $request)
    {
        $discount = $request->percent / 100;
        $sales = $visit->sales()
            ->whereNotNull('base_price')
            ->whereIn('type', $request->filter)
            ->get();
        foreach ($sales as $sale) {
            $bp = $sale->base_price;
            $sale->price_charged = $bp - ($discount * $bp);
            $sale->save();
        }
        return $visit->append('subtotal');
    }

    public function deleteSale(Visit $visit, Sale $sale)
    {
        $sale->forceDelete();
        $visit->load('sales');
        return $visit->append('subtotal');
    }

    public function updateTechnicalSheet(Visit $visit, Request $request)
    {
        $sheet = $visit->technicalSheet;
        if (!$sheet) {
            $sheet = new TechnicalSheet();
            $sheet->client_id = $visit->client_id;
            $sheet->visit_id = $visit->id;
        }
        $sheet->notes = $request->notes;
        $sheet->save();
        $visit->setRelation('technicalSheet', $sheet);
        return $visit->load('sales')->append('subtotal');
    }

    public function deleteTechnicalSheet(Visit $visit)
    {
        $visit->technicalSheet()->forceDelete();
        return $visit->load('sales')->append('subtotal');
    }

    // admin

    public function show(Visit $visit)
    {
        return $visit->load('sales', 'technicalSheet')->append('subtotal');
    }

    public function cancel(Visit $visit)
    {
        $visit->sales()->where('type', 'article')->with('article')->each(function (Sale $sale) {
            $art = $sale->article;
            $art->stock = $art->stock + $sale->quantity;
            $art->save();
        });
        $visit->sales()->delete();
        $visit->delete();
        return $visit->load('sales', 'technicalSheet')->append('subtotal');
    }
}
