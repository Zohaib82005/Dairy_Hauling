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
        Schema::create('tanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained();
            $table->string('tank_id');
            $table->enum('type',['cylindrical','rectangular']);
            $table->decimal('height');
            $table->decimal('width')->nullable();
            $table->decimal('radius')->nullable();
            $table->decimal('capacity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanks');
    }
};
