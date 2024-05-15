<?php

namespace App\Http\Controllers;

use App\Models\CategorieTheme;
use App\Models\Theme;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = CategorieTheme::with('theme')->paginate(20);
        return view('admin.categorie.index', compact('categories'));
    }

    public function create()
    {
        $themes = Theme::all();
        return view('admin.categorie.create', compact('themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'theme_id' => 'required|exists:themes,id',
        ]);

        CategorieTheme::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(CategorieTheme $categorie)
    {
        $themes = Theme::all();
        return view('admin.categorie.edit', compact('categorie', 'themes'));
    }

    public function update(Request $request, CategorieTheme $categorie)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'theme_id' => 'required|exists:themes,id',
        ]);

        $categorie->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(CategorieTheme $categorie)
    {
        $categorie->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
