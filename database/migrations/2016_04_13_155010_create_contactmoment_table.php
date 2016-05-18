<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactmomentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contactmoment', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('les_id')->index('fk_les_idx');
			$table->dateTime('starttijd');
			$table->dateTime('eindtijd');
			$table->text('ruimte', 65535)->nullable();
			
			$table->unique('starttijd');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contactmoment');
	}

}
