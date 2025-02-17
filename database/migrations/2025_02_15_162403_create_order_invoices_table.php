<?php

use App\Models\Order;
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
        Schema::create('order_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->decimal('top_price')->nullable();
            $table->decimal('bottom_price')->nullable();
            $table->decimal('set_price')->nullable();
            $table->decimal('additional_price')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('total_payment')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->decimal('discount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_invoices');
    }
};
