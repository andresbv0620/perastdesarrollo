<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteHasPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente_has_plans', function(Blueprint $table)
		{
			$table->increments('id');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->integer('cliente_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->date('duracion');
            $table->foreign('cliente_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('plan_id')
                ->references('id')
                ->on('plans')
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
		Schema::drop('cliente_has_plans');
	}

}
