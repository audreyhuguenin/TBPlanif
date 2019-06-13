<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
	->references('id')
	->on('users')
	->onDelete('restrict')
	->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('free_days');
    }
}
