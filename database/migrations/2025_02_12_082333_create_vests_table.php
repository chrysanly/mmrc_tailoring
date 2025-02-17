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
        Schema::create('vests', function (Blueprint $table) {
            $table->id();
            $table->string('vest_armhole');
            $table->string('vest_full_length');
            $table->string('vest_shoulder_width');
            $table->string('vest_neck_circumference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vests');
    }
};
