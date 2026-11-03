<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        User::updateOrCreate(
            ['email' => 'admin@colegio.test'],
            [
                'name' => 'Administrador Colegio Padre Luis Variara',
                'password' => 'Variara2026!',
                'is_admin' => true,
            ],
        );
    }
}
