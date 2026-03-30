<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->integer('quantity');

            // --- SNAPSHOT COLUMNS ---
            $table->decimal('price', 8, 2);
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
