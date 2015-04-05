<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaTabletTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sistema_tablet', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->boolean('activo')->default(true);
            $table->integer('tablet_id')->unsigned();
            $table->integer('sistema_id')->unsigned();
            $table->foreign('tablet_id')
                ->references('id')
                ->on('tablets')
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
		Schema::drop('sistema_tablet');
	}

}
