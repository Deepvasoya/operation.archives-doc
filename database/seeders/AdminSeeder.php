<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $admin = User::where('email', 'admin@admin.com')->first();

        if (! $admin) {
            User::create([
                'name'              => 'Admin',
                'email'             => 'admin@admin.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@admin.com');
            $this->command->info('Password: password');
        } else {
            $this->command->info('Admin user already exists!');
        }
    }
}
