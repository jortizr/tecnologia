<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Models\Location;
use App\Models\OperationalState;
use App\Models\PhysicalState;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            // Relaciones principales
            $table->foreignIdFor(DeviceModel::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(DeviceType::class)->constrained();

            // Identificadores únicos
            $table->string('serial_number')->unique();
            // El IMEI es opcional porque no todo equipo es celular
            $table->string('imei')->nullable()->unique();

            // Ubicación y estados
            // Si Locations usa 'location_id' como PK, cámbialo a 'id' en su propia migración
            $table->foreignIdFor(Location::class)->constrained();
            $table->foreignIdFor(OperationalState::class)->constrained();
            $table->foreignIdFor(PhysicalState::class)->constrained();

            $table->date('acquisition_date')->nullable(); // date suele ser suficiente para compras

            // Auditoría (ya los tienes bien, solo asegúrate de que User use 'id')
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes(); // ¡Muy recomendado para inventarios!
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
