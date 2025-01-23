<?php

namespace App\Imports;

use App\Merlin\Tools;
use App\Models\Service;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ServicesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Service([
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
    }
}
