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
        Schema::create('blazers', function (Blueprint $table) {
            $table->id();
            $table->string('blazer_chest');
            $table->string('blazer_shoulder_width');
            $table->string('blazer_length');
            $table->string('blazer_sleeve_length');
            $table->string('blazer_waist');
            $table->string('blazer_hips');
            $table->string('blazer_armhole');
            $table->string('blazer_wrist');
            $table->string('blazer_back_width');
            $table->string('blazer_lower_arm_girth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blazers');
    }
};
