<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Merlin\Tools;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('Prestation.csv', function (array $row) {
            Service::create([
                'id' => $row['Id'],
                'created_at' => now(),
                'updated_at' => Tools::convertDate($row['DateDerModif']),
                'deleted_at' => Tools::convertTimestamp($row['FlagArchive']),
                'service_category_id' => $row['IdPrestationFamille'],
                'sort_order' => $row['Id'] * 10,
                'label' => $row['Libelle'],
                'price' => intval($row['Prix']) / 100,
                'execution_time' => $row['TempsExec'],
                'pause_time' => $row['TempsPause'],
            ]);
        });
    }
}
