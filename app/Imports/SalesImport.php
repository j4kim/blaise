<?php

namespace App\Imports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $service_id = $article_id = $label = null;
        if ($row['TypeLigTik'] == 1) {
            $type = 'service';
            $service_id = $row['NumArticle'];
        } else if ($row['TypeLigTik'] == 2) {
            $type = 'article';
            $article_id = $row['NumArticle'];
        } else {
            $type = 'other';
        }
        return new Sale([
            'id' => $row['Id'],
            'visit_id' => $row['IdCaisseTicket'],
            'service_id' => $service_id,
            'article_id' => $article_id,
            'base_price' => intval($row['PrixDeBase']) / 100,
            'price_charged' => intval($row['PrixPaye']) / 100,
            'quantity' => $row['NbCode'],
            'type' => $type,
            'label' => $label,
        ]);
    }
}
