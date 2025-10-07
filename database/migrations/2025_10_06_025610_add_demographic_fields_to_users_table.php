<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // DIPERBAIKI: Mengubah titik referensi ke kolom 'password' yang pasti ada.
            $table->string('no_wa')->nullable()->after('password');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('no_wa');
            $table->integer('umur')->unsigned()->nullable()->after('jenis_kelamin');
            $table->string('asal_responden')->nullable()->after('umur');
            $table->string('jenis_responden')->nullable()->after('asal_responden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'no_wa',
                'jenis_kelamin',
                'umur',
                'asal_responden',
                'jenis_responden'
            ]);
        });
    }
};
