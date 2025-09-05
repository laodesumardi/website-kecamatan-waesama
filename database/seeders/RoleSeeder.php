<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'display_name' => 'Administrator',
                'description' => 'Full access to all system features'
            ],
            [
                'name' => 'Pegawai',
                'display_name' => 'Pegawai',
                'description' => 'Staff access to manage daily operations'
            ],
            [
                'name' => 'Warga',
                'display_name' => 'Warga',
                'description' => 'Citizen access for services'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
