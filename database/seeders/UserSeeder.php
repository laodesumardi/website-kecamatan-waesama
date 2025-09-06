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
        // Get roles with error handling
        $adminRole = Role::where('name', 'Admin')->first();
        $pegawaiRole = Role::where('name', 'Pegawai')->first();
        $wargaRole = Role::where('name', 'Warga')->first();

        // Check if roles exist
        if (!$adminRole || !$pegawaiRole || !$wargaRole) {
            $this->command->error('Required roles not found. Please run RoleSeeder first.');
            return;
        }

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
                'nik' => '7301010101800002',
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
                'nik' => '7301010101900003',
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
                'nik' => '7301010101880004',
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
                'nik' => '7301010101920005',
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
                'nik' => '7301010101950006',
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
                'nik' => '7301010101930007',
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
                'nik' => '7301010101870008',
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
                'nik' => '7301010101910009',
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
                'nik' => '7301010101940010',
                'birth_date' => '1994-12-30',
                'gender' => 'L',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        // Validate data before insertion
        $allUsers = array_merge($adminUsers, $pegawaiUsers, $wargaUsers);
        $emails = array_column($allUsers, 'email');
        $niks = array_column($allUsers, 'nik');
        
        if (count($emails) !== count(array_unique($emails))) {
            $this->command->error('Duplicate emails found in seeder data.');
            return;
        }
        
        if (count($niks) !== count(array_unique($niks))) {
            $this->command->error('Duplicate NIKs found in seeder data.');
            return;
        }

        // Insert all users with error handling
        try {
            foreach ($adminUsers as $userData) {
                $user = User::firstOrCreate(
                    ['email' => $userData['email']],
                    $userData
                );
                if ($user->wasRecentlyCreated) {
                    $this->command->info('Created admin user: ' . $userData['name']);
                }
            }

            foreach ($pegawaiUsers as $userData) {
                $user = User::firstOrCreate(
                    ['email' => $userData['email']],
                    $userData
                );
                if ($user->wasRecentlyCreated) {
                    $this->command->info('Created pegawai user: ' . $userData['name']);
                }
            }

            foreach ($wargaUsers as $userData) {
                $user = User::firstOrCreate(
                    ['email' => $userData['email']],
                    $userData
                );
                if ($user->wasRecentlyCreated) {
                    $this->command->info('Created warga user: ' . $userData['name']);
                }
            }
        } catch (\Exception $e) {
            $this->command->error('Error creating users: ' . $e->getMessage());
            return;
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin users: ' . count($adminUsers));
        $this->command->info('Pegawai users: ' . count($pegawaiUsers));
        $this->command->info('Warga users: ' . count($wargaUsers));
    }
}
