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
        return view('admin.theme.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:themes,name,null,id,deleted_at,NULL',
        ]);

        Theme::create($validatedData);

        return redirect()->route('admin.theme.index')->with('success', 'Thème créé avec succès.');
    }

    public function edit($id)
    {
        $theme = Theme::findOrFail($id); // Récupère le thème à éditer
        return view('admin.theme.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:themes,name,' . $theme->id . ',id,deleted_at,NULL',
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
