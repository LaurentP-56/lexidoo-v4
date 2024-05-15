<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelsController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        return view('admin.level.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.level.create'); // Assurez-vous que la vue 'create' existe dans 'resources/views/admin/level/'
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'sub_label' => 'nullable|string|max:255',
            'classe' => 'nullable|string|max:255',
        ]);

        Level::create($validatedData);

        return redirect()->route('admin.levels.index')->with('success', 'Niveau créé avec succès.');
    }

    public function edit(Level $level) // Utiliser l'injection de modèle pour simplifier
    {
        return view('admin.level.edit', compact('level')); // Assurez-vous que la vue 'edit' existe dans 'resources/views/admin/level/'
    }

    public function update(Request $request, Level $level) // Utiliser l'injection de modèle pour simplifier
    {
        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'sub_label' => 'nullable|string|max:255',
            'classe' => 'nullable|string|max:255',
        ]);

        $level->update($validatedData);

        return redirect()->route('admin.levels.index')->with('success', 'Niveau mis à jour avec succès.');
    }

    public function destroy(Level $level) // Utiliser l'injection de modèle pour simplifier
    {
        $level->delete();

        return redirect()->route('admin.levels.index')->with('success', 'Niveau supprimé avec succès.');
    }

}
