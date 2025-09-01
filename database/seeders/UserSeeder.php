<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', 'Admin')->first();
        $pegawaiRole = Role::where('name', 'Pegawai')->first();
        $wargaRole = Role::where('name', 'Warga')->first();

        // Create Admin users
        $adminUsers = [
            [
                'name' => 'Administrator Sistem',
                'email' => 'admin@waesama.go.id',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'phone' => '081234567890',
                'address' => 'Kantor Camat Waesama, Jl. Raya Waesama No. 1',
                'nik' => '7301010101850001',
                'birth_date' => '1985-01-01',
                'gender' => 'L',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Camat Waesama',
                'email' => 'camat@waesama.go.id',
                'password' => Hash::make('camat123'),
                'role_id' => $adminRole->id,
                'phone' => '081234567891',
                'address' => 'Kantor Camat Waesama, Jl. Raya Waesama No. 1',
                'nik' => '7301010101800001',
                'birth_date' => '1980-01-01',
                'gender' => 'L',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        // Create Pegawai users
        $pegawaiUsers = [
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@waesama.go.id',
                'password' => Hash::make('pegawai123'),
                'role_id' => $pegawaiRole->id,
                'phone' => '081234567892',
                'address' => 'Jl. Melati No. 15, Waesama',
                'nik' => '7301010101900001',
                'birth_date' => '1990-05-15',
                'gender' => 'P',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@waesama.go.id',
                'password' => Hash::make('pegawai123'),
                'role_id' => $pegawaiRole->id,
                'phone' => '081234567893',
                'address' => 'Jl. Mawar No. 22, Waesama',
                'nik' => '7301010101880001',
                'birth_date' => '1988-08-20',
                'gender' => 'L',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dewi Sartika',
                'email' => 'dewi.sartika@waesama.go.id',
                'password' => Hash::make('pegawai123'),
                'role_id' => $pegawaiRole->id,
                'phone' => '081234567894',
                'address' => 'Jl. Anggrek No. 8, Waesama',
                'nik' => '7301010101920001',
                'birth_date' => '1992-03-10',
                'gender' => 'P',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        // Create Warga users
        $wargaUsers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'password' => Hash::make('warga123'),
                'role_id' => $wargaRole->id,
                'phone' => '081234567895',
                'address' => 'Jl. Kenanga No. 45, Desa Waesama',
                'nik' => '7301010101950001',
                'birth_date' => '1995-07-12',
                'gender' => 'L',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rina Wati',
                'email' => 'rina.wati@gmail.com',
                'password' => Hash::make('warga123'),
                'role_id' => $wargaRole->id,
                'phone' => '081234567896',
                'address' => 'Jl. Dahlia No. 12, Desa Waesama',
                'nik' => '7301010101930001',
                'birth_date' => '1993-11-25',
                'gender' => 'P',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@gmail.com',
                'password' => Hash::make('warga123'),
                'role_id' => $wargaRole->id,
                'phone' => '081234567897',
                'address' => 'Jl. Cempaka No. 33, Desa Waesama',
                'nik' => '7301010101870001',
                'birth_date' => '1987-04-18',
                'gender' => 'L',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sri Mulyani',
                'email' => 'sri.mulyani@gmail.com',
                'password' => Hash::make('warga123'),
                'role_id' => $wargaRole->id,
                'phone' => '081234567898',
                'address' => 'Jl. Tulip No. 7, Desa Waesama',
                'nik' => '7301010101910001',
                'birth_date' => '1991-09-05',
                'gender' => 'P',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Agus Salim',
                'email' => 'agus.salim@gmail.com',
                'password' => Hash::make('warga123'),
                'role_id' => $wargaRole->id,
                'phone' => '081234567899',
                'address' => 'Jl. Sakura No. 19, Desa Waesama',
                'nik' => '7301010101940001',
                'birth_date' => '1994-12-30',
                'gender' => 'L',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        // Insert all users
        foreach ($adminUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        foreach ($pegawaiUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        foreach ($wargaUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin users: ' . count($adminUsers));
        $this->command->info('Pegawai users: ' . count($pegawaiUsers));
        $this->command->info('Warga users: ' . count($wargaUsers));
    }
}