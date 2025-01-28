<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Merlin\Tools;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('Produit.csv', function (array $row) {
            Article::create([
                'id' => $row['Id'],
                'created_at' => now(),
                'updated_at' => Tools::convertDate($row['DateHeure']),
                'deleted_at' => Tools::convertTimestamp($row['FlagArchive']),
                'brand_id' => $row['IdProduitFournisseur'],
                'line_id' => $row['IdProduitGamme'] > 0 ? $row['IdProduitGamme'] : null,
                'barcode' => $row['CodeABarre'],
                'label' => $row['Referen'],
                'retail_price' => $row['Conseille'] == '0' ? null : intval($row['Conseille']) / 100,
                'catalog_price' => intval($row['PrixCatalogue']) / 100,
                'sort_order' => $row['Id'] * 10,
            ]);
        });
    }
}
