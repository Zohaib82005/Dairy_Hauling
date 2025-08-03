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
        Schema::create('farm_stop_scans', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id');
            $table->foreignId('tank_id');
            $table->foreignId('farm_id');
            $table->string('patron_id');
            $table->decimal('collected_milk');
            $table->enum('method',['Stick Reading','Scale At Plant','Estimated Value','Scale At Farm']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_stop_scans');
    }
};
