<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Diperlukan untuk menonaktifkan foreign key

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key check untuk sementara
        Schema::disableForeignKeyConstraints();

        // Kosongkan tabel users dengan aman
        DB::table('users')->truncate();

        // Aktifkan kembali foreign key check
        Schema::enableForeignKeyConstraints();

        // Buat akun Superadmin default
        User::create([
            'username' => 'Super Admin',
            'email' => 'superadmin@app.com',
            'password' => Hash::make('password'), // Password default adalah 'password'
            'role_id' => 1, // ID 1 untuk Superadmin
            'is_active' => true,
        ]);
    }
}
