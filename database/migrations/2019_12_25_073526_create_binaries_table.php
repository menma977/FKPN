<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sponsor')->nullable();
            $table->integer('user')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('invest')->default(0);
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
        Schema::dropIfExists('binaries');
    }
}
