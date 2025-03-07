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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('orderId')->primary();
            $table->string('userId');
            $table->string('firstName');
            $table->string('address');
            $table->string('paymentMethod');
            $table->string('phoneNumber');
            $table->decimal('totalAmount', 10, 2);
            $table->string('orderStatus');
            $table->timestamps();
            
            // $table->foreign('userId')->references('userId')->on('users');
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('orderId');
            $table->string('productId');
            $table->string('productName');
            $table->string('category');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('image');
            $table->timestamps();

            // $table->foreign('orderId')->references('orderId')->on('orders');
            // $table->foreign('productId')->references('productId')->on('products');
        });

        Schema::create('delivered_items', function (Blueprint $table) {
            $table->id();
            $table->string('orderId');
            $table->string('productId');
            $table->string('productName');
            $table->string('category');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('image');
            $table->string('orderStatus');
            $table->timestamps();

            // $table->foreign('orderId')->references('orderId')->on('orders');
            // $table->foreign('productId')->references('productId')->on('products');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
    }
};
