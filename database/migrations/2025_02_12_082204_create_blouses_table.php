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
        Schema::create('blouses', function (Blueprint $table) {
            $table->id();
            $table->string('blouse_bust');
            $table->string('blouse_length');
            $table->string('blouse_waist');
            $table->string('blouse_figure');
            $table->string('blouse_hips');
            $table->string('blouse_shoulder');
            $table->string('blouse_sleeve');
            $table->string('blouse_arm_hole');
            $table->string('blouse_lower_arm_girth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blouses');
    }
};
