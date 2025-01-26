<?php

namespace App\Imports;

use App\Merlin\Tools;
use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ClientsImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Client([
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
    }

    public function batchSize(): int
    {
        return 100;
    }
}
