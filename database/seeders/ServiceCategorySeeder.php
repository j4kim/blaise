<?php

namespace Database\Seeders;

use App\Merlin\Import;
use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Import('PrestationFamille.csv', function (array $row) {
            ServiceCategory::create([
                'id' => $row['Id'],
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => $row['VisibleFacturation'] ? null : now(),
                'sort_order' => $row['ColonneTri'],
                'label' => $row['NomService'],
            ]);
        });

        ServiceCategory::where('id', 4)->update([
            'options' => ['preventDelete' => true, 'forceTechnicalSheet' => true]
        ]);
    }
}
