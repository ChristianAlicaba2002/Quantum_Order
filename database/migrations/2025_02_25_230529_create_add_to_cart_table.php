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
        Schema::create('add_to_cart', function (Blueprint $table) {
            $table->id();
            $table->string('productId');
            $table->string('productName');
            $table->string('category');
            $table->integer('price');
            $table->integer('stock');
            $table->integer('quantity');
            $table->string('description');
            $table->string('image');
            $table->string('userId')->constrained('register_user');;
            $table->string('username')->constrained('register_user');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_to_cart');
    }
};
