<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('username');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('confirmation_code');
			$table->string('remember_token')->nullable();
			$table->boolean('isconfirmed')->default(false);
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('users_social_keys',function($table){
			$table->engine = 'InnoDB';
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			//Facebook
			$table->string('fb_userkey');
			$table->string('fb_secret');

			//Twitter
			$table->string('tw_userkey');
			$table->string('tw_secret');

			//LinkedIn
			$table->string('In_userkey');
			$table->string('In_secret');
			$table->timestamps();
		});


		Schema::create('password_reminders',function($table){
			$table->engine = 'InnoDB';
			$table->string('email');
			$table->string('token');
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('password_reminders');
		Schema::drop('users_social_keys');
		Schema::drop('users');
	}

}

