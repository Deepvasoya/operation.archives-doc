<?php
namespace Database\Seeders;

use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Usager;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get usagers
        $ayoub   = Usager::where('cin', 'CD789013')->first();
        $youssef = Usager::where('cin', 'C98989')->first();
        $said    = Usager::where('cin', 'AV77687')->first();

        // Get operation types
        $extraitNaissance    = OperationType::where('nom', 'Demande d\'extrait d\'acte de naissance')->first();
        $deposerDemande      = OperationType::where('nom', 'Déposer une demande')->first();
        $certificatResidence = OperationType::where('nom', 'Demande de certificat de résidence')->first();
        $demandeCIN          = OperationType::where('nom', 'Demande de CIN')->first();

        if ($ayoub && $extraitNaissance && $deposerDemande) {
            // Ayoub ESSADEQ - 2 operations on 05/12/2025
            Operation::create([
                'usager_id'         => $ayoub->id,
                'operation_type_id' => $extraitNaissance->id,
                'created_at'        => Carbon::create(2025, 12, 5, 10, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 5, 10, 0, 0),
            ]);

            Operation::create([
                'usager_id'         => $ayoub->id,
                'operation_type_id' => $deposerDemande->id,
                'created_at'        => Carbon::create(2025, 12, 5, 14, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 5, 14, 0, 0),
            ]);
        }

        if ($youssef && $demandeCIN && $certificatResidence && $extraitNaissance && $deposerDemande) {
            // Youssef - 4 operations on 03/12/2025
            Operation::create([
                'usager_id'         => $youssef->id,
                'operation_type_id' => $demandeCIN->id,
                'created_at'        => Carbon::create(2025, 12, 3, 9, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 3, 9, 0, 0),
            ]);

            Operation::create([
                'usager_id'         => $youssef->id,
                'operation_type_id' => $certificatResidence->id,
                'created_at'        => Carbon::create(2025, 12, 3, 11, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 3, 11, 0, 0),
            ]);

            Operation::create([
                'usager_id'         => $youssef->id,
                'operation_type_id' => $extraitNaissance->id,
                'created_at'        => Carbon::create(2025, 12, 3, 13, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 3, 13, 0, 0),
            ]);

            Operation::create([
                'usager_id'         => $youssef->id,
                'operation_type_id' => $deposerDemande->id,
                'created_at'        => Carbon::create(2025, 12, 3, 15, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 3, 15, 0, 0),
            ]);
        }

        if ($said && $certificatResidence) {
            // Said Dami - 2 operations on 05/12/2025
            Operation::create([
                'usager_id'         => $said->id,
                'operation_type_id' => $certificatResidence->id,
                'created_at'        => Carbon::create(2025, 12, 5, 10, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 5, 10, 0, 0),
            ]);

            Operation::create([
                'usager_id'         => $said->id,
                'operation_type_id' => $certificatResidence->id,
                'created_at'        => Carbon::create(2025, 12, 5, 16, 0, 0),
                'updated_at'        => Carbon::create(2025, 12, 5, 16, 0, 0),
            ]);
        }
    }
}
