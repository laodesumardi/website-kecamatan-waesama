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
        // Seed roles first
        $this->call(RoleSeeder::class);

        // Create admin user
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@kantorcamat.com',
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        // Create test pegawai user
        $pegawaiRole = \App\Models\Role::where('name', 'pegawai')->first();
        
        User::factory()->create([
            'name' => 'Pegawai Test',
            'email' => 'pegawai@kantorcamat.com',
            'role_id' => $pegawaiRole->id,
            'is_active' => true,
        ]);
    }
}
