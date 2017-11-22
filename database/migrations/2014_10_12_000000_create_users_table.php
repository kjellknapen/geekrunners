<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('medals1')->default(0);
            $table->integer('medals2')->default(0);
            $table->integer('medals3')->default(0);
            $table->string('role')->nullable();
            $table->boolean('notifications')->default(false);
            $table->string('gender');
            $table->string('avatar');
            $table->string('email')->unique();
            $table->string('strava_id');
            $table->string('token');
            $table->rememberToken();
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
