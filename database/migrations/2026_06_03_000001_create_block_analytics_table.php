<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('block_analytics')) {
            return;
        }

        Schema::create('block_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('block_id')->unique();
            $table->string('block_name');
            $table->string('district_id')->index();
            $table->unsignedBigInteger('registered')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('block_analytics');
    }
};
