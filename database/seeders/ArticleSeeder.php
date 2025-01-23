<?php

namespace Database\Seeders;

use App\Imports\ArticlesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ArticlesImport, 'Produit.csv', 'merlin-csv');
    }
}
