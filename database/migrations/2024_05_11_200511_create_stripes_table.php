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
        Schema::create('stripes', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('sub_total');
            $table->string('discount')->nullable();
            $table->string('charge');
            $table->string('total');
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('zip');
            $table->string('company')->nullable();
            $table->string('notes')->nullable();
            $table->string('ship_check')->nullable();
            $table->string('ship_fname')->nullable();
            $table->string('ship_lname')->nullable();
            $table->string('ship_country')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_zip')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('ship_email')->nullable();
            $table->string('ship_phone')->nullable();
            $table->string('ship_address')->nullable();
            $table->string('payment_method');
            $table->string('customer_id');
            $table->string('coupon_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripes');
    }
};
