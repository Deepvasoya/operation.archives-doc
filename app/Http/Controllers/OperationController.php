<?php
namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Usager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OperationController extends Controller
{
    /**
     * Store a newly created operation in storage.
     */
    public function store(Request $request, string $usagerId)
    {
        $validated = $request->validate([
            'operation_type_id' => 'required|exists:operation_types,id',
            'description'       => 'nullable|string',
            'date'              => 'required|date',
            'numero_operation'  => 'nullable|string|max:255|unique:operations,numero_operation',
            'piece_jointe'      => 'nullable|file|max:10240', // 10MB max
        ]);

        $usager = Usager::findOrFail($usagerId);

        // Handle file upload
        if ($request->hasFile('piece_jointe')) {
            $file                      = $request->file('piece_jointe');
            $fileName                  = time() . '_' . $file->getClientOriginalName();
            $path                      = $file->storeAs('operations', $fileName, 'public');
            $validated['piece_jointe'] = $path;
        }

        $validated['usager_id'] = $usager->id;
        Operation::create($validated);

        // Update usager's operation count
        $usager->increment('nombre_operations');

        return redirect()->route('usagers.show', $usagerId)->with('success', 'Opération créée avec succès.');
    }

    /**
     * Show the form for editing the specified operation.
     */
    public function edit(string $id)
    {
        $operation      = Operation::with('operationType')->findOrFail($id);
        $operationTypes = \App\Models\OperationType::orderBy('nom')->get();
        return view('content.operations.edit', compact('operation', 'operationTypes'));
    }

    /**
     * Update the specified operation in storage.
     */
    public function update(Request $request, string $id)
    {
        $operation = Operation::findOrFail($id);
        $usagerId  = $operation->usager_id;

        $validated = $request->validate([
            'operation_type_id' => 'required|exists:operation_types,id',
            'description'       => 'nullable|string',
            'date'              => 'required|date',
            'numero_operation'  => 'nullable|string|max:255|unique:operations,numero_operation,' . $id,
            'piece_jointe'      => 'nullable|file|max:10240', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('piece_jointe')) {
            // Delete old file if exists
            if ($operation->piece_jointe && Storage::disk('public')->exists($operation->piece_jointe)) {
                Storage::disk('public')->delete($operation->piece_jointe);
            }

            $file                      = $request->file('piece_jointe');
            $fileName                  = time() . '_' . $file->getClientOriginalName();
            $path                      = $file->storeAs('operations', $fileName, 'public');
            $validated['piece_jointe'] = $path;
        }

        $operation->update($validated);

        return redirect()->route('usagers.show', $usagerId)->with('success', 'Opération mise à jour avec succès.');
    }

    /**
     * Remove the specified operation from storage.
     */
    public function destroy(string $id)
    {
        $operation = Operation::findOrFail($id);
        $usagerId  = $operation->usager_id;

        // Delete file if exists
        if ($operation->piece_jointe && Storage::disk('public')->exists($operation->piece_jointe)) {
            Storage::disk('public')->delete($operation->piece_jointe);
        }

        $operation->delete();

        // Update usager's operation count
        $usager = Usager::findOrFail($usagerId);
        $usager->decrement('nombre_operations');

        return redirect()->route('usagers.show', $usagerId)->with('success', 'Opération supprimée avec succès.');
    }
}
