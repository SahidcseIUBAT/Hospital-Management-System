<?php

// database/migrations/2025_01_01_000002_create_doctors_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('specialty');
    $table->string('phone')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
