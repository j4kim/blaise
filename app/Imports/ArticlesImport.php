<?php

namespace App\Imports;

use App\Merlin\Tools;
use App\Models\Article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArticlesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Article([
            'id' => $row['Id'],
            'created_at' => now(),
            'updated_at' => Tools::convertDate($row['DateHeure']),
            'deleted_at' => Tools::convertTimestamp($row['FlagArchive']),
            'brand_id' => $row['IdProduitFournisseur'],
            'line_id' => $row['IdProduitGamme'] > 0 ? $row['IdProduitGamme'] : null,
            'barcode' => $row['CodeABarre'],
            'label' => $row['Referen'],
            'retail_price' => $row['Conseille'] == '0' ? null : intval($row['Conseille']) / 100,
            'catalog_price' => intval($row['PrixCatalogue']) / 100,
            'sort_order' => $row['Id'] * 10,
        ]);
    }
}
