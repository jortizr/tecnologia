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
        Schema::create('colaborators', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('last_names');
            $table->string('identification')->unique();
            $table->string('payroll_code')->unique();
            $table->string('department');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaborators');
    }
};
