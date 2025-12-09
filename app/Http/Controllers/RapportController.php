<?php
namespace App\Http\Controllers;

use App\Models\OperationType;
use App\Models\Usager;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $query = Usager::with(['operations.operationType']);

        // Filter by date range
        if ($request->filled('date_debut')) {
            $query->whereHas('operations', function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_debut);
            });
        }

        if ($request->filled('date_fin')) {
            $query->whereHas('operations', function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_fin);
            });
        }

        // Filter by operation type
        if ($request->filled('type_operation')) {
            $query->whereHas('operations', function ($q) use ($request) {
                $q->where('operation_type_id', $request->type_operation);
            });
        }

        $usagers = $query->get();

        // Get operation types for filter dropdown
        $operationTypes = OperationType::all();

        // Process data for display
        $rapports = $usagers->map(function ($usager) use ($request) {
            $operations = $usager->operations;

            // Apply date filters if set
            if ($request->filled('date_debut')) {
                $operations = $operations->filter(function ($op) use ($request) {
                    return $op->created_at->format('Y-m-d') >= $request->date_debut;
                });
            }

            if ($request->filled('date_fin')) {
                $operations = $operations->filter(function ($op) use ($request) {
                    return $op->created_at->format('Y-m-d') <= $request->date_fin;
                });
            }

            // Apply operation type filter if set
            if ($request->filled('type_operation')) {
                $operations = $operations->filter(function ($op) use ($request) {
                    return $op->operation_type_id == $request->type_operation;
                });
            }

            // Group operations by type and count
            $operationsByType = $operations->groupBy('operation_type_id')->map(function ($ops, $typeId) {
                $type = OperationType::find($typeId);
                return [
                    'nom'   => $type ? $type->nom : 'Inconnu',
                    'count' => $ops->count(),
                ];
            });

            // Format operations details
            $detailsOperations = $operationsByType->map(function ($op) {
                return $op['nom'] . ' (' . $op['count'] . ')';
            })->implode(', ');

            // Get last operation date
            $derniereOperation = $operations->sortByDesc('created_at')->first();

            return [
                'usager'                  => $usager,
                'nombre_operations'       => $operations->count(),
                'details_operations'      => $detailsOperations ?: '-',
                'date_derniere_operation' => $derniereOperation ? $derniereOperation->created_at->format('d/m/Y') : '-',
            ];
        });

        return view('content.rapports.index', compact('rapports', 'operationTypes'));
    }

    public function generatePdf($usagerId)
    {
        $usager = Usager::with(['operations.operationType'])->findOrFail($usagerId);

        // Sort operations by date
        $operations = $usager->operations->sortBy('created_at');

        $data = [
            'usager'          => $usager,
            'operations'      => $operations,
            'date_generation' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('content.rapports.pdf', $data);

        return $pdf->download('rapport_' . $usager->nom . '_' . $usager->cin . '.pdf');
    }
}
