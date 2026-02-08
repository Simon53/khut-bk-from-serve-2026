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
        Schema::create('category_banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_menu_id'); // relation field
            $table->string('banner_image')->nullable(); // ব্যানার ইমেজ (optional)
            $table->string('title')->nullable();        // টাইটেল (optional)
            $table->timestamps();

            // Foreign Key
            $table->foreign('main_menu_id')
                  ->references('id')->on('main_menus')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_banners');
    }
};
