<?php


namespace App\Imports;

use App\Models\Mot;
use Maatwebsite\Excel\Concerns\ToModel;

class WordsImport implements ToModel
{
    public function model(array $row)
    {
        return new Mot([
            'nom' => $row[0],
            'level_id' => $row[1],
            'traduction' => $row[2],
            'commentaire' => $row[3] ?? null,
            'gratuit' => $row[4] ?? 0,
            // Ajoutez d'autres champs si nécessaire
        ]);
    }
}

