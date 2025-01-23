<?php

namespace Database\Seeders;

use App\Imports\LinesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new LinesImport, 'ProduitGamme.csv', 'merlin-csv');
    }
}
