<?php

namespace App\Http\Controllers;

use App\Imports\WordsImport;
use App\Models\Level;
use App\Models\Mot;
use App\Models\Theme;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MotsController extends Controller
{
    public function index()
    {
        $mots   = Mot::with('level')->paginate(20);
        $levels = Level::all();
        return view('admin.mots.index', compact('mots', 'levels'));
    }

    public function create()
    {
        $levels = Level::all();
        $themes = Theme::all();
        return view('admin.mots.create', compact('levels', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'             => 'required|string|max:255',
            'traduction'      => 'required|string|max:255',
            'levels'          => 'required',
            'theme_id'        => 'required|exists:themes,id',
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        $levels = implode(',', $validated['levels']);

        $mot                  = new Mot();
        $mot->nom             = $validated['nom'];
        $mot->traduction      = $validated['traduction'];
        $mot->levels          = $levels;
        $mot->gratuit         = isset($validated['gratuit']) ? 1 : 0;
        $mot->theme_id        = $validated['theme_id'];
        $mot->category_id     = $validated['category_id'];
        $mot->sub_category_id = $validated['sub_category_id'];
        $mot->save();

        return redirect()->route('admin.mots.index')->with('success', 'Mot créé avec succès.');
    }

    public function edit(Mot $mot)
    {
        $levelList = Level::all();
        $themes    = Theme::all();
        $levels    = explode(',', $mot->levels);
        return view('admin.mots.edit', compact('mot', 'levelList', 'themes', 'levels'));
    }

    public function update(Request $request, Mot $mot)
    {
        $validated = $request->validate([
            'nom'             => 'required|string|max:255',
            'traduction'      => 'required|string|max:255',
            'levels'          => 'required',
            'gratuit'         => 'required',
            'theme_id'        => 'required|exists:themes,id',
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        $levels = implode(',', $validated['levels']);

        $mot->nom             = $validated['nom'];
        $mot->traduction      = $validated['traduction'];
        $mot->levels          = $levels;
        $mot->gratuit         = isset($validated['gratuit']) ? 1 : 0;
        $mot->theme_id        = $validated['theme_id'];
        $mot->category_id     = $validated['category_id'];
        $mot->sub_category_id = $validated['sub_category_id'];
        $mot->save();

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
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ]);

        Excel::import(new WordsImport, $request->file('file'));
        return back()->with('success', 'Mots importés avec succès.');
    }
}
