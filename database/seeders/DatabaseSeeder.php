<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        
        // Seed in order of dependencies
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PendudukSeeder::class,
            BeritaSeeder::class,
            SuratSeeder::class,
            AntrianSeeder::class,
            PengaduanSeeder::class,
        ]);
        
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('📋 Summary:');
        $this->command->info('- Roles: Admin, Pegawai, Warga');
        $this->command->info('- Users: 2 Admin, 3 Pegawai, 5 Warga');
        $this->command->info('- Sample data for all modules created');
        $this->command->info('');
        $this->command->info('🔑 Login credentials:');
        $this->command->info('Admin: admin@waesama.go.id / admin123');
        $this->command->info('Pegawai: siti.aminah@waesama.go.id / pegawai123');
        $this->command->info('Warga: budi.santoso@gmail.com / warga123');
    }
}
