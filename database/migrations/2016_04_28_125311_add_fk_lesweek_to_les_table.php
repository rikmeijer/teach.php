<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFKLesweekToLesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('les', function(Blueprint $table)
		{
			$table->foreign(['jaar', 'kalenderweek'], 'fk_leslesweek')->references(['jaar', 'kalenderweek'])->on('lesweek')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('les', function(Blueprint $table)
		{
			$table->dropForeign('fk_leslesweek');
		});
	}

}
