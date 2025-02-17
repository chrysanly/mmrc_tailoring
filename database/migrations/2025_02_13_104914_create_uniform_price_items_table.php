<?php

use App\Models\UniformPrice;
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
        Schema::create('uniform_price_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UniformPrice::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('value');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uniform_price_items');
    }
};
