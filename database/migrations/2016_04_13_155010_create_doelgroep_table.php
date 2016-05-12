<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoelgroepTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doelgroep', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('ervaring', array('veel','redelijk veel','weinig','geen'));
			$table->integer('grootte');
			$table->text('beschrijving', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('doelgroep');
	}

}
