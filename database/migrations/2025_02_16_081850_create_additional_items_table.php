<?php

use App\Models\Order;
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
        Schema::create('additional_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->integer('threads')->nullable();
            $table->integer('zipper')->nullable();
            $table->integer('school_seal')->nullable();
            $table->integer('buttons')->nullable();
            $table->integer('hook_and_eye')->nullable();
            $table->integer('tela')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_items');
    }
};
