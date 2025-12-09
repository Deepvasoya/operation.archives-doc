<?php
namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Utilisateur::query();

        // Custom filters
        if ($request->filled('filter_nom')) {
            $query->where('nom', 'like', '%' . $request->filter_nom . '%');
        }

        if ($request->filled('filter_cin')) {
            $query->where('cin', 'like', '%' . $request->filter_cin . '%');
        }

        if ($request->filled('filter_email')) {
            $query->where('email', 'like', '%' . $request->filter_email . '%');
        }

        // Sorting
        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if (in_array($sortBy, ['nom', 'cin', 'email', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $utilisateurs = $query->paginate(10)->appends($request->query());

        return view('content.utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.utilisateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'      => 'required|string|max:255',
            'cin'      => 'required|string|max:255|unique:utilisateurs,cin',
            'email'    => 'required|email|max:255|unique:utilisateurs,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Utilisateur::create($validated);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('content.utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('content.utilisateurs.edit', compact('utilisateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $validated = $request->validate([
            'nom'      => 'required|string|max:255',
            'cin'      => 'required|string|max:255|unique:utilisateurs,cin,' . $id,
            'email'    => 'required|email|max:255|unique:utilisateurs,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $utilisateur->update($validated);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
