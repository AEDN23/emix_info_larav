<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\departemen::create(['nama_departemen' => 'QC', 'deskripsi' => 'Quality Control']);
        \App\Models\departemen::create(['nama_departemen' => 'QA', 'deskripsi' => 'Quality Assurance']);
        \App\Models\departemen::create(['nama_departemen' => 'PRODUCTION', 'deskripsi' => 'Production Department']);
        \App\Models\departemen::create(['nama_departemen' => 'LAB', 'deskripsi' => 'Laboratory']);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Emix',
            'username' => 'admin',
            'email' => 'admin@emix.co.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'User Emix',
            'username' => 'user',
            'email' => 'user@emix.co.id',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        User::factory()->create([
            'name' => 'Leader Emix',
            'username' => 'leader',
            'email' => 'leader@emix.co.id',
            'password' => bcrypt('password'),
            'role' => 'leader',
        ]);
        // Create Sample Documents
        $this->call([
            CoaSeeder::class,
            WiSeeder::class,
            StdSeeder::class,
            MsdsSeeder::class,
        ]);
    }
}
