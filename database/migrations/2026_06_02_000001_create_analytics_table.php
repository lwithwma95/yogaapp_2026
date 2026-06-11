<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('analytics')) {
            return;
        }

        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->string('district_code')->unique();
            $table->string('district_name');
            $table->unsignedBigInteger('count')->default(0);   // registered participants
            $table->unsignedBigInteger('total')->default(0);   // total members
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
