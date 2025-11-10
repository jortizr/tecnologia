<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('last_name');
            $table->string('identification')->unique();
            $table->string('payroll_code')->unique();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('regional_id')->constrained();
            $table->foreignId('occupation_id')->constrained();
            $table->boolean('is_active')->default(true);
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained();
            $table->foreignIdFor(User::class,'updated_by')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
