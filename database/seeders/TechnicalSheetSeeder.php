<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Merlin\Tools;
use App\Models\TechnicalSheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicalSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('ClientSousFiche.csv', function (array $row) {
            $date = Tools::convertDate($row['DateFiche']);
            if (!$date || !$row['String1']) return;
            TechnicalSheet::create([
                'id' => $row['Id'],
                'created_at' => $date,
                'updated_at' => now(),
                'client_id' => intval($row['IdClient']),
                'notes' => $row['String1'],
            ]);
        });
    }
}
