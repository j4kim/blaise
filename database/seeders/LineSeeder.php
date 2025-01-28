<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Models\Line;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('ProduitGamme.csv', function (array $row) {
            Line::create([
                'id' => $row['Id'],
                'name' => $row['NomGamme'],
            ]);
        });
    }
}
