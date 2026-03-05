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
        Schema::table('device_models', function (Blueprint $table) {
            // Solo intentamos crearla si NO existe ya en la tabla
            if (!Schema::hasColumn('device_models', 'device_type_id')) {
                $table->foreignId('device_type_id')
                    ->after('brand_id')
                    ->constrained('device_types')
                    ->onDelete('cascade');
            }
        });

        // Limpiamos la tabla devices
        Schema::table('devices', function (Blueprint $table) {


            if (Schema::hasColumn('devices', 'device_type_id')) {
                dump("creando el campo en devices");
                $table->dropForeign(['device_type_id']);
                $table->dropColumn('device_type_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_models', function (Blueprint $table) {
            $table->dropForeign(['device_type_id']);
            $table->dropColumn(['device_type_id']);
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->foreignId('device_type_id')
                  ->nullable()
                  ->constrained('device_types');
        });
    }
};
