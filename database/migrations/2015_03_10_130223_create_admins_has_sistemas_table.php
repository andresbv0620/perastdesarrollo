<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsHasSistemasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_has_sistemas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->boolean('activo')->default(true);
            $table->integer('admin_id')->unsigned();
            $table->integer('sistema_id')->unsigned();
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
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
		Schema::drop('admin_has_sistemas');
	}

}
