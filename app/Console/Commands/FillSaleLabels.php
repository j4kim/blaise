<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class FillSaleLabels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-sale-labels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill label column in sales table according to label of the service or article';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $services = Service::withTrashed()->get();
        $articles = Article::withTrashed()->get();

        $processed = 0;
        $count = Sale::count();

        Sale::chunk(1000, function (Collection $sales) use (&$processed, $count, $articles, $services) {
            foreach ($sales as $sale) {
                if ($sale->article_id) {
                    $article = $articles->findOrFail($sale->article_id);
                    $sale->setRelation('article', $article);
                    $sale->computeLabel();
                } else if ($sale->service_id) {
                    $service = $services->findOrFail($sale->service_id);
                    $sale->label = $service->label;
                } else {
                    $sale->label = 'Autre';
                }
                $sale->save();
            }
            $processed += $sales->count();
            $this->comment("Processed $processed/$count");
        });
    }
}
