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
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('country')->default('Bangladesh');
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('apartment')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('ship_to_different')->default(false);
            $table->enum('payment_method', ['cod', 'bkash'])->default('cod');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('delivery_charge', 10, 2)->default(80);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
