<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  productId
    //  productName
    //  category
    //  userId
    //  firstName
    //  address
    //  phoneNumber
    //  totalPrice
    //  stock
    public function up(): void
    {
        Schema::create('check_out_items', function (Blueprint $table) {
            $table->id();
            $table->string('productId')->contrainted('add_to_cart');
            $table->string('productName')->contrainted('add_to_cart');
            $table->string('category')->contrainted('add_to_cart');
            $table->integer('stock')->contrainted('add_to_cart');
            $table->integer('totalPrice');
            $table->string('userId')->contrainted('add_to_cart');
            $table->string('firstName')->contrainted('users');;
            $table->string('address')->contrainted('users');;
            $table->string('phoneNumber')->contrainted('users');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_out');
    }
};
