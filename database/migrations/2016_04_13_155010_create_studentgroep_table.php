<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentgroepTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('studentgroep', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('naam', 5);
			$table->integer('blok_id')->index('fk_blok_idx');
			$table->unique(['naam','blok_id'], 'naam');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('studentgroep');
	}

}
