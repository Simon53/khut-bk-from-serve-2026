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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->text('details')->nullable();
            $table->string('main_image')->nullable();
            $table->unsignedBigInteger('main_menu_id')->nullable();
            $table->unsignedBigInteger('sub_menu_id')->nullable();
            $table->unsignedBigInteger('child_menu_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->date('sale_from_dates')->nullable();
            $table->date('Sale_to_dates')->nullable();
            $table->string('tax_status')->nullable();
            $table->string('tax_class')->nullable();
            $table->string('stock_management')->nullable();
            $table->string('stock_status')->nullable();
            $table->string('link_status');
            $table->string('sold_individually')->nullable();
            $table->string('weight_kg')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('site_view_status')->nullable();
            $table->string('published_site')->nullable();
            $table->string('festive_collection')->nullable();
            $table->string('new_arrivals')->nullable();
            $table->string('patchwork')->nullable();
            $table->string('feature')->nullable();
            $table->string('highlight')->nullable();
            $table->string('bottom_fastive')->nullable();
            $table->string('product_serial')->nullable();
            $table->string('product_barcode')->nullable();
            

            $table->timestamps();
            // Optional foreign keys
            $table->foreign('main_menu_id')->references('id')->on('main_menus')->onDelete('set null');
            $table->foreign('sub_menu_id')->references('id')->on('sub_menus')->onDelete('set null');
            $table->foreign('child_menu_id')->references('id')->on('child_menus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
