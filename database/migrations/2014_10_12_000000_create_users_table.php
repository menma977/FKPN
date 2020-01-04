<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rule')->default(1);
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_x');
            $table->text('ktp_img')->nullable();
            $table->text('ktp_img_user')->nullable();
            $table->string('ktp_number')->unique();
            $table->string('phone')->unique();
            $table->text('image')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('village')->nullable();
            $table->string('number_address');
            $table->text('description_address');
            $table->text('jamkiri')->nullable();
            $table->text('jmlkiri')->nullable();
            $table->text('rkiri')->nullable();
            $table->text('mkiri')->nullable();
            $table->text('rewardkiri')->nullable();
            $table->text('rewardrkiri')->nullable();
            $table->text('jamkana')->nullable();
            $table->text('jmlkanan')->nullable();
            $table->text('rkanan')->nullable();
            $table->text('mkanan')->nullable();
            $table->text('rewardkanan')->nullable();
            $table->text('rewardrkanan')->nullable();
            $table->integer('premium')->default(0);
            $table->integer('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
