<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlokTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blok', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nummer', 45)->unique('nummer_UNIQUE');
			$table->enum('semester', array('1','2','3','4','5','6','7','8'))->index('fk_periode_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blok');
	}

}
