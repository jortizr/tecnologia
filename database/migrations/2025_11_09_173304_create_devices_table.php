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
            $table->foreignIdFor(DeviceModel::class)->constrained();
            $table->foreignIdFor(DeviceType::class)->constrained();
            $table->string('serial_number');
            $table->string('imei');
            $table->foreignIdFor(Location::class)->constrained();
            $table->foreignIdFor(OperationalState::class)->constrained();
            $table->foreignIdFor(PhysicalState::class)->constrained();
            $table->dateTime('acquisition_date');
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
        Schema::dropIfExists('devices');
    }
};
