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
        Schema::create('child_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_menu_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('sub_menu_id')->references('id')->on('sub_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_menus');
    }
};
