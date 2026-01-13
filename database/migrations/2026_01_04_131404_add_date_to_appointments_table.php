<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_add_date_to_appointments_table.php
public function up()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->date('date')->nullable()->after('doctor_id');

    });
}

public function down()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropColumn('date');
    });
}

};
