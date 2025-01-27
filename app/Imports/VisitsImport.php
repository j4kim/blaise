<?php

namespace App\Imports;

use App\Merlin\Tools;
use App\Models\Visit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VisitsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Visit([
            'id' => $row['Id'],
            'created_at' => now(),
            'updated_at' => now(),
            'client_id' => $row['IdClient'],
            'visit_date' => Tools::convertTimestamp($row['DateHeure']),
            'billed' => intval($row['PrixFacture']) / 100,
        ]);
    }
}
