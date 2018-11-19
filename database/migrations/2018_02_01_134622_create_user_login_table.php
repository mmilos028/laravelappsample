<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('sqlite')->dropIfExists('user_login');
      Schema::connection('sqlite')->create('user_login', function (Blueprint $table) {
          $table->increments('user_login_id')->nullable();
          $table->string('username')->nullable();
          $table->string('password')->nullable();
          $table->dateTime('login_time')->nullable();
          $table->dateTime('logout_time')->nullable();
          $table->bigInteger('backoffice_session_id')->nullable();
          $table->text('session_data')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sqlite')->dropIfExists('user_login');
    }
}
