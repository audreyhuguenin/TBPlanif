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
            $table->date('date');
            $table->integer('duration');
            $table->json('type');
            $table->boolean('suiviDA');
            $table->boolean('unmovable');
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
        Schema::dropIfExists('assignations');
    }
}
