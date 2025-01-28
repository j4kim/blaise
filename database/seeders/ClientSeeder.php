<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Merlin\Tools;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('Client.csv', function (array $row) {
            Client::create([
                'id' => $row['Id'],
                'created_at' => Tools::convertDate($row['DateCreation']),
                'updated_at' => Tools::convertDate($row['DerVisite']),
                'deleted_at' => Tools::convertTimestamp($row['FlagArchive']),
                'first_name' => $row['Prenom'],
                'last_name' => $row['Nom'],
                'tel_1' => $row['Tel1'],
                'tel_2' => $row['Tel2'],
                'tel_3' => $row['Tel3'],
                'npa' => $row['CodePostal'],
                'location' => $row['Ville'],
                'gender' => $row['Sexe'],
            ]);
        });
    }
}
