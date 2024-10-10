<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebhookToClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('webhook')->nullable(); // URL du webhook de chaque client
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('webhook');
        });
    }
}
