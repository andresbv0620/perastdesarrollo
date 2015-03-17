<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteHasSistemasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente_has_sistemas', function(Blueprint $table)
		{
			$table->increments('id');
            $table->boolean('activo')->default(true);
			$table->timestamps();
            $table->integer('cliente_id')->unsigned();
            $table->integer('sistema_id')->unsigned();
            $table->foreign('cliente_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('sistema_id')
                ->references('id')
                ->on('sistemas')
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
		Schema::drop('cliente_has_sistemas');
	}

}
