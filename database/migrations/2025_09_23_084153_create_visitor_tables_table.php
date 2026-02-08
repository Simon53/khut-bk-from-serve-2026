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
       Schema::create('visitor_tables', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('ip_address', 45); // ipv4/ipv6
            $table->timestamp('visit_time')->useCurrent(); // default current time
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_tables');
    }
};
