<?php

namespace Database\Seeders;

use App\Imports\ServiceCategoriesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Benchmark;
use Maatwebsite\Excel\Facades\Excel;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $t = Benchmark::measure(
            fn() =>
            Excel::import(new ServiceCategoriesImport, 'PrestationFamille.csv', 'merlin-csv')
        );
        echo $t . " ms\n";
    }
}
