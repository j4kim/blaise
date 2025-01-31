<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Merlin\Tools;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('CaisseTicket.csv', function (array $row) {
            if ($row['IdClient'] == -1) return;
            Visit::create([
                'id' => $row['Id'],
                'created_at' => now(),
                'updated_at' => now(),
                'client_id' => $row['IdClient'],
                'visit_date' => Tools::convertTimestamp($row['DateHeure']),
                'billed' => intval($row['PrixFacture']) / 100,
            ]);
        });
    }
}
