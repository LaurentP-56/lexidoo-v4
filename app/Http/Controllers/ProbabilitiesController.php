<?php

namespace App\Http\Controllers;

use App\Models\ProbabilityLevel;
use Illuminate\Http\Request;

class ProbabilitiesController extends Controller
{
    public function index()
    {
        $probability = ProbabilityLevel::first();
        if (!$probability) {
            $probability = new ProbabilityLevel();
            $probability->save();
        }
        return view('admin.probability.index', compact('probability'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'know'      => 'required|string|max:255',
            'dont_know' => 'nullable|string|max:255',
        ]);

        $probability            = ProbabilityLevel::first();
        $probability->know      = $request->know;
        $probability->dont_know = $request->dont_know;
        $probability->save();

        return redirect()->route('admin.probabilities.index')->with('success', 'Probabilities updated successfully');
    }
}
