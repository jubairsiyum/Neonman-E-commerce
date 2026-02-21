<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Admin Account ─────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@neonman.com'],
            [
                'name'              => 'Admin',
                'email'             => 'admin@neonman.com',
                'password'          => Hash::make('admin@123'),
                'role'              => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ]
        );

        // ── Customer Account ──────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'customer@neonman.com'],
            [
                'name'              => 'Test Customer',
                'email'             => 'customer@neonman.com',
                'password'          => Hash::make('customer@123'),
                'role'              => User::ROLE_CUSTOMER,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✓ Seeded: admin@neonman.com  (password: admin@123)');
        $this->command->info('✓ Seeded: customer@neonman.com  (password: customer@123)');
    }
}
