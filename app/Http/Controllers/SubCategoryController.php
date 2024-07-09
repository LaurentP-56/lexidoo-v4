<?php

namespace App\Http\Controllers;

use App\Models\CategorieTheme;
use App\Models\Theme;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function index()
    {
        $categories = CategorieTheme::all();
        $themes     = Theme::all();
        return view('sub-category.index', compact('categories', 'themes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @author Bhavesh Vyas
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'          => 'required',
            'theme_id'     => 'required',
            'categorie_id' => 'required',
        ]);

        CategorieTheme::create($request->all());
        return redirect()->route('sub-category.index')->with('success', 'Sub Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CategorieTheme $categorie
     * @return void
     * @author Bhavesh Vyas
     */
    public function edit(CategorieTheme $categorie)
    {
        $themes = Theme::all();
        return view('sub-category.edit', compact('categorie', 'themes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CategorieTheme $categorie
     * @return void
     * @author Bhavesh Vyas
     */
    public function update(Request $request, CategorieTheme $categorie)
    {
        $request->validate([
            'nom'          => 'required',
            'theme_id'     => 'required',
            'categorie_id' => 'required',
        ]);

        $categorie->update($request->all());
        return redirect()->route('sub-category.index')->with('success', 'Sub Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategorieTheme $categorie
     * @return void
     * @throws \Exception
     * @author Bhavesh Vyas
     */
    public function destroy(CategorieTheme $categorie)
    {
        $categorie->delete();
        return redirect()->route('sub-category.index')->with('success', 'Sub Category deleted successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function create()
    {
        $themes = Theme::all();
        return view('sub-category.create', compact('themes'));
    }

    /**
     * Display the specified resource.
     *
     * @param CategorieTheme $categorie
     * @return void
     * @author Bhavesh Vyas
     */
    public function show(CategorieTheme $categorie)
    {
        return view('sub-category.show', compact('categorie'));
    }
}
