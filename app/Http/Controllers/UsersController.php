<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', 'desc') === 'asc' ? 'asc' : 'desc';

        $users = User::query()
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('email', 'LIKE', "%{$searchTerm}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(20);

        return view('admin.users.index', compact('users', 'searchTerm', 'sortBy', 'sortDirection'));
    }

    public function updatePremiumStatus(Request $request, User $user)
    {
        $user->premium = !$user->premium;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Statut premium mis à jour avec succès.');
    }
}
