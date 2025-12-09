<?php
namespace Database\Seeders;

use App\Models\Usager;
use Illuminate\Database\Seeder;

class UsagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usagers = [
            [
                'nom'               => 'Ayoub ESSADEQ',
                'cin'               => 'CD789013',
                'email'             => 'essadeqayoub14@gmail.com',
                'telephone'         => '0762479434',
                'nombre_operations' => 2,
            ],
            [
                'nom'               => 'Said Dami',
                'cin'               => 'AV77687',
                'email'             => null,
                'telephone'         => '87678687687',
                'nombre_operations' => 2,
            ],
            [
                'nom'               => 'Wade Nelson',
                'cin'               => 'Quia ex vitae et occ',
                'email'             => 'hagas@mailinator.com',
                'telephone'         => '+1 (665) 823-9024',
                'nombre_operations' => 0,
            ],
            [
                'nom'               => 'Youssef',
                'cin'               => 'C98989',
                'email'             => null,
                'telephone'         => '87678687687',
                'nombre_operations' => 4,
            ],
        ];

        foreach ($usagers as $usager) {
            Usager::create($usager);
        }
    }
}
