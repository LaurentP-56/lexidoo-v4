<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Theme;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with('theme')->paginate(20);
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
            'name'     => 'required|string|max:255|unique:categories,name,null,id,deleted_at,NULL',
            'theme_id' => 'required|exists:themes,id',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(Category $categorie)
    {
        $themes = Theme::all();
        return view('admin.categorie.edit', compact('categorie', 'themes'));
    }

    public function update(Request $request, Category $categorie)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:categories,name,' . $categorie->id . ',id,deleted_at,NULL',
            'theme_id' => 'required|exists:themes,id',
        ]);

        $categorie->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $categorie)
    {
        $categorie->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
