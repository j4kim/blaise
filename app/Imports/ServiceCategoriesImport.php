<?php

namespace App\Imports;

use App\Models\ServiceCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ServiceCategoriesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ServiceCategory([
            'id' => $row['Id'],
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => $row['VisibleFacturation'] ? null : now(),
            'sort_order' => $row['ColonneTri'],
            'label' => $row['NomService'],
        ]);
    }
}
