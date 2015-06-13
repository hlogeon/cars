<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $t)
		{
			$t->increments('id');

			$t->string('email');
			$t->string('password', 64);
			$t->string('name');

			$t->boolean('is_admin');

			$t->dateTime('new_logged_in');
			$t->dateTime('last_logged_in');

			$t->boolean('confirmed')->default(0);
			$t->string('confirmation_code')->nullable();

			// $t->boolean('email_subscr');

			$t->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}

}