<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_profits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('roi')->default('1');
            $table->string('roi_max')->default('15');
            $table->string('ticket')->default('100000');
            $table->string('sponsor')->default('15');
            $table->string('pairing')->default('10');
            $table->string('reinvest')->default('300');
            $table->string('capping')->default('300');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_profits');
    }
}
