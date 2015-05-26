<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sistemas', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('nombreDataBase');
            $table->string('description');
            $table->string('nombre_db')->unique();
            $table->timestamps();
		});
        DB::statement("ALTER TABLE sistemas ADD logo_sistema LONGBLOB");
        DB::statement("ALTER TABLE sistemas ADD imagen_fondo LONGBLOB");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sistemas');
	}

}
