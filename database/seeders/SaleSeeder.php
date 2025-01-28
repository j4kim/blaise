<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('CaisseLigTicket.csv', function (array $row) {
            $service_id = $article_id = $label = null;
            if ($row['TypeLigTik'] == 1) {
                $type = 'service';
                $service_id = $row['NumArticle'];
            } else if ($row['TypeLigTik'] == 2) {
                $type = 'article';
                $article_id = $row['NumArticle'];
            } else {
                $type = 'other';
            }
            Sale::create([
                'id' => $row['Id'],
                'visit_id' => $row['IdCaisseTicket'],
                'service_id' => $service_id,
                'article_id' => $article_id,
                'base_price' => intval($row['PrixDeBase']) / 100,
                'price_charged' => intval($row['PrixPaye']) / 100,
                'quantity' => $row['NbCode'],
                'type' => $type,
                'label' => $label,
            ]);
        });
    }
}
