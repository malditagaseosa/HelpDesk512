<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudeHasProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitude_has_problems', function (Blueprint $table) {
            $table->integer('solicitude_id')->unsigned()->index();
            $table->foreign('solicitude_id')->references('id')->on('solicitude')->onDelete('restrict');

            $table->integer('problems_id')->unsigned()->index();
            $table->foreign('problems_id')->references('id')->on('problems')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitude_has_problems');
    }
}
