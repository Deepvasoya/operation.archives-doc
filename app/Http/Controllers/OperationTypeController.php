<?php
namespace App\Http\Controllers;

use App\Models\OperationType;
use Illuminate\Http\Request;

class OperationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OperationType::query();

        // Custom filters
        if ($request->filled('filter_nom')) {
            $query->where('nom', 'like', '%' . $request->filter_nom . '%');
        }

        // Sorting
        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if (in_array($sortBy, ['nom', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $operationTypes = $query->paginate(10)->appends($request->query());

        return view('content.operation-types.index', compact('operationTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.operation-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:operation_types,nom',
        ]);

        OperationType::create($validated);

        return redirect()->route('operation-types.index')->with('success', 'Type d\'opération créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $operationType = OperationType::findOrFail($id);
        return view('content.operation-types.show', compact('operationType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $operationType = OperationType::findOrFail($id);
        return view('content.operation-types.edit', compact('operationType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $operationType = OperationType::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:operation_types,nom,' . $id,
        ]);

        $operationType->update($validated);

        return redirect()->route('operation-types.index')->with('success', 'Type d\'opération mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $operationType = OperationType::findOrFail($id);
        $operationType->delete();

        return redirect()->route('operation-types.index')->with('success', 'Type d\'opération supprimé avec succès.');
    }
}
