<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateOpcionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('opciones', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('option_name');
            $table->integer('option_order');
            $table->string('field_type');
            $table->integer('entrada_id')->unsigned();
            $table->timestamps();

            $table->foreign('entrada_id')
                ->references('id')
                ->on('entradas')
                ->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('opciones');
	}

}
