<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entradas', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('field_name');
            $table->string('field_description');
            $table->string('field_type');
            $table->boolean('field_required')->default(true);
            $table->integer('tab_id')->unsigned();
			$table->timestamps();

            $table->foreign('tab_id')
                ->references('id')
                ->on('tabs')
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
		Schema::drop('entradas');
	}

}
