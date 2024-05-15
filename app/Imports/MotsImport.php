<?php

namespace App\Imports;

use App\Models\Mot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MotsImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return new Mot([
            'nom' => $row['nom'],
            'level' => $row['level'], // Assurez-vous que le niveau est géré correctement selon votre logique d'application
            'traduction' => $row['traduction'],
            'commentaire' => $row['commentaire'] ?? null, // Utilisez l'opérateur Null Coalescing pour les champs optionnels
            'audio' => $row['audio'] ?? null, // Gérer l'importation d'audio si nécessaire
            'gratuit' => $row['gratuit'],
            'probability_of_appearance' => $row['probability_of_appearance'],
            'level_id' => $row['level_id'],
            // 'theme_id' => $row['theme_id'], // Assurez-vous d'ajouter 'theme_id' si présent dans votre CSV
        ]);
    }
}
