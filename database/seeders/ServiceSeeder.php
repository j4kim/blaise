<?php

namespace Database\Seeders;

use App\Imports\ServicesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Benchmark;
use Maatwebsite\Excel\Facades\Excel;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $t = Benchmark::measure(
            fn() =>
            Excel::import(new ServicesImport, 'Prestation.csv', 'merlin-csv')
        );
        echo $t . " ms\n";
    }
}
