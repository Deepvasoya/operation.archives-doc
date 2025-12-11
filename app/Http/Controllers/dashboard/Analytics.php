<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Usager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Analytics extends Controller
{
    public function index()
    {
        // Total Usagers
        $totalUsagers     = Usager::count();
        $usagersThisMonth = Usager::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $usagersLastMonth = Usager::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        $usagersGrowth = $usagersLastMonth > 0
            ? round((($usagersThisMonth - $usagersLastMonth) / $usagersLastMonth) * 100, 1)
            : ($usagersThisMonth > 0 ? 100 : 0);

        // Total Opérations
        $totalOperations     = Operation::count();
        $operationsThisMonth = Operation::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $operationsLastMonth = Operation::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        $operationsGrowth = $operationsLastMonth > 0
            ? round((($operationsThisMonth - $operationsLastMonth) / $operationsLastMonth) * 100, 1)
            : ($operationsThisMonth > 0 ? 100 : 0);

        // Usager le plus Actif
        $mostActiveUsager = Usager::withCount('operations')
            ->orderBy('operations_count', 'desc')
            ->first();

        // Type d'Opération le plus Populaire
        $mostPopularType = OperationType::withCount('operations')
            ->orderBy('operations_count', 'desc')
            ->first();

        // Opérations par Type (pour le graphique)
        $operationsByType = OperationType::withCount('operations')
            ->orderBy('operations_count', 'desc')
            ->get()
            ->map(function ($type) {
                return [
                    'nom'   => $type->nom,
                    'count' => $type->operations_count,
                ];
            });

        // Opérations par Date (pour le graphique)
        $operationsByDate = Operation::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'date'  => Carbon::parse($item->date)->format('d/m/Y'),
                    'count' => $item->count,
                ];
            });

        // Derniers 10 Usagers
        $latestUsagers = Usager::orderBy('created_at', 'desc')
            ->limit(10)
            ->get(['nom', 'cin', 'email']);

        // Dernières 10 Opérations
        $latestOperations = Operation::with('operationType')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($operation) {
                return [
                    'type' => $operation->operationType->nom,
                    'date' => $operation->created_at->format('d/m/Y'),
                ];
            });

        return view('content.dashboard.dashboards-analytics', compact(
            'totalUsagers',
            'usagersGrowth',
            'totalOperations',
            'operationsGrowth',
            'mostActiveUsager',
            'mostPopularType',
            'operationsByType',
            'operationsByDate',
            'latestUsagers',
            'latestOperations'
        ));
    }
}
