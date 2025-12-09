<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user
        $this->call([
            AdminSeeder::class,
            UsagerSeeder::class,
            OperationTypeSeeder::class,
            OperationSeeder::class,
        ]);

        // Uncomment to create test users
        // User::factory(10)->create();
    }
}
