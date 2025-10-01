<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Diperlukan untuk menonaktifkan foreign key

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key check untuk sementara
        Schema::disableForeignKeyConstraints();

        // Kosongkan tabel roles dengan aman
        DB::table('roles')->truncate();

        // Aktifkan kembali foreign key check
        Schema::enableForeignKeyConstraints();

        // Buat data peran yang dibutuhkan
        Role::create([
            'role_name' => 'Superadmin',
            'code'      => 'SA'
        ]); // Akan mendapatkan ID 1

        Role::create([
            'role_name' => 'Admin',
            'code'      => 'ADM'
        ]);      // Akan mendapatkan ID 2

        Role::create([
            'role_name' => 'User',
            'code'      => 'USR'
        ]);       // Akan mendapatkan ID 3
    }
}
