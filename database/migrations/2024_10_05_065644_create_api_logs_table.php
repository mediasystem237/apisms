<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiLogsTable extends Migration
{
    public function up()
    {
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // Remplacez user_id par client_id
            $table->string('status');
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();

            // Clé étrangère pour client_id
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_logs');
    }
}
