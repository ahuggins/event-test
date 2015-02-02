<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locations',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
			$table->string('address');
			$table->string('city');
			$table->string('state');
			$table->string('zip');
			$table->string('hours');
			$table->integer('image_id');
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
		Schema::drop('locations');
	}

}
