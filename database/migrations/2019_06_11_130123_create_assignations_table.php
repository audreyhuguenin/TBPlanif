<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->integer('duration');
            $table->json('type');
            $table->boolean('suiviDA');
            $table->boolean('unmovable');
            $table->timestamps();
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')
	->references('id')
	->on('tasks')
	->onDelete('restrict')
	->onUpdate('restrict');
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
        Schema::dropIfExists('assignations');
    }
}
