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
        Schema::create('schedules', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('channel_id');
            $table->string('channel_name');
            $table->boolean('is_overlapping');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('title');
            $table->string('short_description');
            $table->integer('age_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
