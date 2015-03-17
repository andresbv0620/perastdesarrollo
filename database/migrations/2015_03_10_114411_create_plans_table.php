<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plans', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('nombre');
            $table->integer('usuariosAdmins');
            $table->integer('usuariosReportes');
            $table->integer('cantidadTablets');
            $table->integer('sistemas');
            $table->date('duracion');
            $table->decimal('precio');
            $table->enum('periodicidad',['mensual','anual']);
            $table->string('planCol');
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
		Schema::drop('plans');
	}

}
