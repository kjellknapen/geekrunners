<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('strava_id');
            $table->dateTime('date');
            $table->string('name');
            $table->string('map_id');
            $table->float('average_speed');
            $table->float('max_speed');
            $table->float('km');
            $table->integer('minutes');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('activities', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
