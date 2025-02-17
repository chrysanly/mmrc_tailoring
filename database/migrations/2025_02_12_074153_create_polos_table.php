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
        Schema::create('polos', function (Blueprint $table) {
            $table->id();
            $table->double('polo_chest');
            $table->double('polo_length');
            $table->double('polo_hips');
            $table->double('polo_shoulder');
            $table->double('polo_sleeve');
            $table->double('polo_armhole');
            $table->double('polo_lower_arm_girth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polos');
    }
};
