<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_thumbnails', function (Blueprint $table) {
            // Drop old foreign keys if exist
            try {
                $table->dropForeign(['thumb_color']);
            } catch (\Exception $e) {}

            try {
                $table->dropForeign(['thumb_size']);
            } catch (\Exception $e) {}

            try {
                $table->dropForeign(['thumb_common_size']);
            } catch (\Exception $e) {}
        });

        // Now change columns to string
        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->string('thumb_color')->nullable()->change();
            $table->string('thumb_size')->nullable()->change();
            $table->string('thumb_common_size')->nullable()->change();
            $table->string('thumb_barcode')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_thumbnails', function (Blueprint $table) {
            $table->unsignedBigInteger('thumb_color')->change();
            $table->unsignedBigInteger('thumb_size')->change();
            $table->unsignedBigInteger('thumb_common_size')->change();
            $table->string('thumb_barcode')->nullable()->change();
        });
    }
};
