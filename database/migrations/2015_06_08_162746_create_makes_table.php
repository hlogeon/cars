<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('makes', function(Blueprint $t)
		{
			$t->increments('id');

			$t->string('name');
			$t->string('title');
			$t->string('icon');
			$t->boolean('soviet');

			$t->index('name');

			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('makes');
	}

}
