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
        Schema::create('order_users', function (Blueprint $table) {
            $table->id();
            $table->string('productId');
            $table->string('productName');
            $table->string('payment');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('category');
            $table->string('description');
            $table->string('image');
            $table->string('userIdLogin')->constrained('register_user');
            $table->string('userNameLogin')->constrained('register_user');
            $table->string('userAddress')->constrained('register_user');
            $table->string('userPhoneNumber')->constrained('register_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_users');
    }
};
