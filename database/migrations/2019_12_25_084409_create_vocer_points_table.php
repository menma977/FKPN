<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocerPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocer_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user');
            $table->integer('bonus_id');
            $table->text('description');
            $table->integer('debit')->default(0);
            $table->integer('credit')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('vocer_points');
    }
}
