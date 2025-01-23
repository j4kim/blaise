<?php

namespace Database\Seeders;

use App\Imports\ClientsImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ClientsImport, 'Client.csv', 'merlin-csv');
    }
}
