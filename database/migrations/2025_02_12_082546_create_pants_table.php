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
        Schema::create('pants', function (Blueprint $table) {
            $table->id();
            $table->string('pants_length');
            $table->string('pants_waist');
            $table->string('pants_hips');
            $table->string('pants_scrotch');
            $table->string('pants_knee_height');
            $table->string('pants_knee_circumference');
            $table->string('pants_bottom_circumferem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pants');
    }
};
