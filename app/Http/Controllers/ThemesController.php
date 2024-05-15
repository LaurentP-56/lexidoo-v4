<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemesController extends Controller
{
    public function index()
    {
        $themes = Theme::paginate(20);
        return view('admin.theme.index', compact('themes'));
    }

    public function create()
    {
        // Récupérer tous les thèmes ou seulement les thèmes parents si nécessaire
        $themes = Theme::whereNull('parent_id')->get(); // Exemple pour récupérer seulement les thèmes parents
        return view('admin.theme.create', compact('themes'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Theme::create($validatedData);

        return redirect()->route('admin.theme.index')->with('success', 'Thème créé avec succès.');
    }

    public function edit($id)
    {
        $theme = Theme::findOrFail($id); // Récupère le thème à éditer
        $themes = Theme::where('id', '!=', $id)->get(); // Récupère tous les autres thèmes pour la sélection du parent, en excluant le thème actuel

        return view('admin.theme.edit', compact('theme', 'themes')); // Passe les thèmes à la vue
    }

    public function update(Request $request, Theme $theme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:themes,id'
        ]);

        $theme->update($validated);

        return redirect()->route('admin.theme.index')->with('success', 'Thème mis à jour avec succès.');
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();
        return redirect()->route('admin.theme.index')->with('success', 'Thème supprimé avec succès.');
    }
}
