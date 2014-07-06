<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('title');
			$table->dateTime('start_time');
			$table->dateTime('end_time');
			$table->string('location');
			$table->string('created_by');
			$table->string('hosted_by');
			$table->string('event_type');
			$table->text('description');
			$table->boolean('is_private')->default(false);
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('tags',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('tag_text');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('events-tags-relation',function($table){
			$table->engine = 'InnoDB';
			$table->integer('event_id')->unsigned()->index();
			$table->integer('tag_id')->unsigned()->index();
			$table->foreign('event_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events-tags-relation');
		Schema::drop('tags');
		Schema::drop('events');
	}

}

