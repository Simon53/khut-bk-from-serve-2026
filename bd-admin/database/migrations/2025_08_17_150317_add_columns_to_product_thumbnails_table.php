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
        Schema::table('product_thumbnails', function (Blueprint $table) {
        $table->unsignedBigInteger('thumb_color')->nullable()->after('image_path');
        $table->unsignedBigInteger('thumb_size')->nullable()->after('thumb_color');
        $table->unsignedBigInteger('thumb_common_size')->nullable()->after('thumb_size');
        $table->string('thumb_barcode')->nullable()->after('thumb_common_size');

      
        $table->foreign('thumb_color')->references('id')->on('colors')->onDelete('set null');
        $table->foreign('thumb_size')->references('id')->on('body_sizes')->onDelete('set null');
        $table->foreign('thumb_common_size')->references('id')->on('common_sizes')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_thumbnails', function (Blueprint $table) {
            //
        });
    }
};
