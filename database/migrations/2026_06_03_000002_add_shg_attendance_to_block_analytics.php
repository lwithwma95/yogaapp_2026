<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('block_analytics', function (Blueprint $table) {
            if (!Schema::hasColumn('block_analytics', 'total_shg')) {
                $table->unsignedBigInteger('total_shg')->default(0)->after('district_id');
            }
            if (!Schema::hasColumn('block_analytics', 'attendance')) {
                $table->unsignedBigInteger('attendance')->default(0)->after('total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('block_analytics', function (Blueprint $table) {
            $table->dropColumn(['total_shg', 'attendance']);
        });
    }
};
