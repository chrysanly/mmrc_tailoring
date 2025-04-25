<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->noActionOnDelete();
            $table->string('date');
            $table->string('time');
            $table->string('status')->default('pending');
            $table->string('top')->nullable();
            $table->string('bottom')->nullable();
            $table->string('school')->nullable();
            $table->string('set')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
