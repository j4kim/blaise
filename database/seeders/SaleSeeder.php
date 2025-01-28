<?php

namespace Database\Seeders;

use App\Imports\SalesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new SalesImport, 'CaisseLigTicket.csv', 'merlin-csv');
    }
}
