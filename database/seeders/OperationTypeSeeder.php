<?php
namespace Database\Seeders;

use App\Models\OperationType;
use Illuminate\Database\Seeder;

class OperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operationTypes = [
            ['nom' => 'test'],
            ['nom' => 'Déposer une demande'],
            ['nom' => 'Demande d\'extrait d\'acte de naissance'],
            ['nom' => 'Demande de certificat de résidence'],
            ['nom' => 'Demande de CIN'],
        ];

        foreach ($operationTypes as $operationType) {
            OperationType::create($operationType);
        }
    }
}
