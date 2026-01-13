<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('doctors', function (Blueprint $table) {
        $table->unsignedInteger('fee')->default(0)->after('specialty');
    });
}

public function down()
{
    Schema::table('doctors', function (Blueprint $table) {
        $table->dropColumn('fee');
    });
}

};
