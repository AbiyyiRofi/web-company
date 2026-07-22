<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(BranchSeeder::class);

        User::firstOrCreate(
            ['email' => 'admin@pdamindramayu.co.id'],
            [
                'name' => 'Admin PDAM',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );
    }
}
