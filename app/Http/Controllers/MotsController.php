<?php

namespace App\Http\Controllers;

use App\Imports\WordsImport;
use App\Models\Category;
use App\Models\Level;
use App\Models\Mot;
use App\Models\Theme;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MotsController extends Controller
{
    public function index()
    {
        $mots = Mot::with('level')->paginate(20);
        return view('admin.mots.index', compact('mots'));
    }

    public function create()
    {
        $levels     = Level::all(); // Récupère tous les niveaux   
        $themes = Theme::all();
        // Passe les variables à la vue
        return view('admin.mots.create', compact('levels','themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'                       => 'required|string|max:255',
            'traduction'                => 'required|string|max:255',
            'level_id'                  => 'required|exists:levels,id',
            'gratuit'                   => 'required|boolean',
            'probability_of_appearance' => 'required|numeric',
        ]);

        Mot::create($validated);

        return redirect()->route('admin.mots.index')->with('success', 'Mot créé avec succès.');
    }

    public function edit(Mot $mot)
    {
        $levels = Level::all();
        return view('admin.mots.edit', compact('mot', 'levels'));
    }

    public function update(Request $request, Mot $mot)
    {
        $validated = $request->validate([
            'nom'                       => 'required|string|max:255',
            'traduction'                => 'required|string|max:255',
            'level_id'                  => 'required|exists:levels,id',
            'gratuit'                   => 'required|boolean',
            'probability_of_appearance' => 'required|numeric',
        ]);

        $mot->update($validated);

        return redirect()->route('admin.mots.index')->with('success', 'Mot mis à jour avec succès.');
    }

    public function destroy(Mot $mot)
    {
        $mot->delete();
        return redirect()->route('admin.mots.index')->with('success', 'Mot supprimé avec succès.');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        Excel::import(new WordsImport, $request->file('file'));

        return back()->with('success', 'Mots importés avec succès.');
    }

    /**
     * Get category by theme id
     *
     * @param Request $request
     * @return response
     * @author Bhavesh Vyas
     */
    public function getCategory(Request $request)
    {
        return response([
            'success'    => true,
            'categories' => getCategory($request->theme_id),
        ], 200);
    }

    /**
     * Get category by theme id
     *
     * @param Request $request
     * @return response
     * @author Bhavesh Vyas
     */
    public function getSubCategory(Request $request)
    {
        return response([
            'success'    => true,
            'subcategories' => getSubCategory($request->category_id),
        ], 200);
    }
}
