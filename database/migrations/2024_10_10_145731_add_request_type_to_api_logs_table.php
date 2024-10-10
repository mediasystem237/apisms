<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestTypeToApiLogsTable extends Migration
{
    public function up()
    {
        Schema::table('api_logs', function (Blueprint $table) {
            $table->string('request_type')->nullable(); // Add the request_type column
        });
    }

    public function down()
    {
        Schema::table('api_logs', function (Blueprint $table) {
            $table->dropColumn('request_type'); // Remove the column if rolled back
        });
    }
}
