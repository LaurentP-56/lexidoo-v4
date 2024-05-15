<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarifs;

class TarifsController extends Controller
{
    /**
     * Afficher tous les tarifs.
     */
    public function index()
    {
        $tarifs = Tarifs::all();
        return view('admin.tarifs.index', compact('tarifs')); // Assurez-vous que cette vue existe dans resources/views/tarifs
    }

    /**
     * Afficher le formulaire de création d'un nouveau tarif.
     */
    public function create()
    {
        return view('admin.tarifs.create'); // Assurez-vous que cette vue existe
    }

    /**
     * Enregistrer un nouveau tarif dans la base de données.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom_offre' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'duree' => 'nullable|string|max:255',
        ]);

        Tarifs::create($validatedData);
        return redirect()->route('admin.tarifs.index')->with('success', 'Tarif créé avec succès.');
    }

    /**
     * Afficher un tarif spécifique par son ID.
     */
    public function show($id)
    {
        $tarif = Tarifs::findOrFail($id);
        return view('admin.tarifs.show', compact('tarif')); // Assurez-vous que cette vue existe
    }

    /**
     * Afficher le formulaire d'édition pour un tarif spécifique.
     */
    public function edit($id)
    {
        $tarif = Tarifs::findOrFail($id);
        return view('admin.tarifs.edit', compact('tarif')); // Assurez-vous que cette vue existe
    }

    /**
     * Mettre à jour un tarif spécifique dans la base de données.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom_offre' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'duree' => 'nullable|string|max:255',
        ]);

        $tarif = Tarifs::findOrFail($id);
        $tarif->update($validatedData);

        return redirect()->route('admin.tarifs.index')->with('success', 'Tarif mis à jour avec succès.');
    }

    /**
     * Supprimer un tarif spécifique de la base de données.
     */
    public function destroy($id)
    {
        $tarif = Tarifs::findOrFail($id);
        $tarif->delete();
        return redirect()->route('admin.tarifs.index')->with('success', 'Tarif supprimé avec succès.');
    }

    // Notez que la méthode `search` pourrait être ajustée pour fonctionner avec les vues,
    // mais j'ai omis cela ici pour simplifier.
}
