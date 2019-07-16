<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('sent');
            $table->integer('weeknumber');
            $table->timestamps();
            $table->integer('parent_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
	->references('id')
	->on('users')
	->onDelete('restrict')
	->onUpdate('restrict');
            $table->foreign('parent_id')
                  ->references('id')
                ->on('plannings')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plannings');
    }
}
