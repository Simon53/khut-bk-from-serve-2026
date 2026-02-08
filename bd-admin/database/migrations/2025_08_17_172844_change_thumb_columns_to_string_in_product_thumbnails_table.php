<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // প্রথমে foreign key constraint drop করো
        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->dropForeign(['thumb_color']);
            $table->dropForeign(['thumb_size']);
            $table->dropForeign(['thumb_common_size']);
        });

        // এখন কলাম টাইপ পরিবর্তন করা যাবে
        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->string('thumb_color')->change();
            $table->string('thumb_size')->change();
            $table->string('thumb_common_size')->change();
            $table->string('thumb_barcode')->nullable()->change();
        });

        // চাইলে constraint পুনরায় add করতে পারো
        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->foreign('thumb_color')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('thumb_size')->references('id')->on('body_sizes')->onDelete('cascade');
            $table->foreign('thumb_common_size')->references('id')->on('common_sizes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->dropForeign(['thumb_color']);
            $table->dropForeign(['thumb_size']);
            $table->dropForeign(['thumb_common_size']);
        });

        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->unsignedBigInteger('thumb_color')->change();
            $table->unsignedBigInteger('thumb_size')->change();
            $table->unsignedBigInteger('thumb_common_size')->change();
            $table->unsignedBigInteger('thumb_barcode')->nullable()->change();
        });

        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->foreign('thumb_color')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('thumb_size')->references('id')->on('body_sizes')->onDelete('cascade');
            $table->foreign('thumb_common_size')->references('id')->on('common_sizes')->onDelete('cascade');
        });
    }
};
