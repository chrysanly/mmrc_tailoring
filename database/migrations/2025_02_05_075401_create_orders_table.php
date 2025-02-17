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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->noActionOnDelete();
            $table->string('order_type');
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->string('school')->nullable();
            $table->string('top')->nullable();
            $table->string('bottom')->nullable();
            $table->string('set')->nullable();
            $table->string('quantity')->nullable();
            $table->string('size')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
