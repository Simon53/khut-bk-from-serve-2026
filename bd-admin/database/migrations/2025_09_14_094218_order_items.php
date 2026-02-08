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
         Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('thumbnail_id')->nullable(); // নির্বাচিত থাম্বনেইল
            $table->unsignedBigInteger('option_id')->nullable();    // নির্বাচিত অপশন (যদি থাকে)

            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('total', 10, 2);

            // রিলেশন কপি করার জন্য
            $table->string('selected_size')->nullable();
            $table->string('selected_body_size')->nullable();
            $table->string('selected_color')->nullable();

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('thumbnail_id')->references('id')->on('product_thumbnails')->onDelete('set null');
            $table->foreign('option_id')->references('id')->on('product_options')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
