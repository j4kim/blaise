<?php

namespace Database\Seeders;

use App\Imports\VisitsImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new VisitsImport, 'CaisseTicket.csv', 'merlin-csv');
    }
}
