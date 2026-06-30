<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed akun admin default dan akun user contoh.
     */
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@artikelwisata.com'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@artikelwisata.com',
                'password' => Hash::make('admin123456'),
                'role'     => 'admin',
            ]
        );

        // Akun User Contoh
        User::updateOrCreate(
            ['email' => 'user@artikelwisata.com'],
            [
                'name'     => 'User Demo',
                'email'    => 'user@artikelwisata.com',
                'password' => Hash::make('user123456'),
                'role'     => 'user',
            ]
        );

        $this->command->info('✓ Akun admin dan user demo berhasil dibuat.');
    }
}
