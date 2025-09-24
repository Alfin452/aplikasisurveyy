<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan ini merujuk ke 'unit_kerjas' (jamak)
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->foreignId('tipe_unit_id')->after('end_time')->constrained('tipe_units')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Pastikan ini juga merujuk ke 'unit_kerjas' (jamak)
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->dropForeign(['tipe_unit_id']);
            $table->dropColumn('tipe_unit_id');
        });
    }
};
