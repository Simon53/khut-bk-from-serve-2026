<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
         Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thumbnail_id'); // 
            $table->unsignedBigInteger('common_size_id')->nullable();
            $table->unsignedBigInteger('body_size_id')->nullable();
            $table->string('barcode')->nullable();
            $table->timestamps();

            // 🔹 Foreign Keys
            $table->foreign('thumbnail_id')->references('id')->on('product_thumbnails')->onDelete('cascade');
            $table->foreign('common_size_id')->references('id')->on('common_sizes')->nullOnDelete();
            $table->foreign('body_size_id')->references('id')->on('body_sizes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_options');
    }
};
