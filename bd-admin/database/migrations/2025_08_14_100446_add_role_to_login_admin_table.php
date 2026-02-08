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
    Schema::table('login_admin', function (Blueprint $table) {
        if (!Schema::hasColumn('login_admin', 'role')) {
            $table->string('role')->default('viewer')->after('email');
        }

        if (!Schema::hasColumn('login_admin', 'created_at') && !Schema::hasColumn('login_admin', 'updated_at')) {
            $table->timestamps();
        }
    });
}

public function down(): void
{
    Schema::table('login_admin', function (Blueprint $table) {
        if (Schema::hasColumn('login_admin', 'role')) {
            $table->dropColumn('role');
        }
        if (Schema::hasColumn('login_admin', 'created_at') && Schema::hasColumn('login_admin', 'updated_at')) {
            $table->dropTimestamps();
        }
    });
}
};
