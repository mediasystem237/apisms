<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            $table->string('delivery_status')->nullable(); // Statut de la livraison
            $table->timestamp('delivery_time')->nullable(); // Heure de livraison
        });
    }

    public function down()
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            $table->dropColumn('delivery_status');
            $table->dropColumn('delivery_time');
        });
    }

};
