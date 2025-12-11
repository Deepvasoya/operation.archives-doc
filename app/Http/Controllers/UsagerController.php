<?php
namespace App\Http\Controllers;

use App\Models\Usager;
use Illuminate\Http\Request;

class UsagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Usager::query();

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

        if ($request->filled('filter_telephone')) {
            $query->where('telephone', 'like', '%' . $request->filter_telephone . '%');
        }

        // Add operations count
        $query->withCount('operations');

        // Sorting
        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if (in_array($sortBy, ['nom', 'cin', 'email', 'telephone', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } elseif ($sortBy === 'nombre_operations') {
            // Sort by operations count from relationship
            $query->orderBy('operations_count', $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $usagers = $query->paginate(10)->appends($request->query());

        return view('content.usagers.index', compact('usagers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.usagers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'               => 'required|string|max:255',
            'cin'               => 'required|string|max:255|unique:usagers,cin',
            'email'             => 'nullable|email|max:255',
            'telephone'         => 'nullable|string|max:255',
            'nombre_operations' => 'nullable|integer|min:0',
        ]);

        Usager::create($validated);

        return redirect()->route('usagers.index')->with('success', 'Usager créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usager         = Usager::with(['operations.operationType'])->findOrFail($id);
        $operationTypes = \App\Models\OperationType::orderBy('nom')->get();
        return view('content.usagers.show', compact('usager', 'operationTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usager = Usager::findOrFail($id);
        return view('content.usagers.edit', compact('usager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usager = Usager::findOrFail($id);

        $validated = $request->validate([
            'nom'               => 'required|string|max:255',
            'cin'               => 'required|string|max:255|unique:usagers,cin,' . $id,
            'email'             => 'nullable|email|max:255',
            'telephone'         => 'nullable|string|max:255',
            'nombre_operations' => 'nullable|integer|min:0',
        ]);

        $usager->update($validated);

        return redirect()->route('usagers.index')->with('success', 'Usager mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usager = Usager::findOrFail($id);
        $usager->delete();

        return redirect()->route('usagers.index')->with('success', 'Usager supprimé avec succès.');
    }
}
