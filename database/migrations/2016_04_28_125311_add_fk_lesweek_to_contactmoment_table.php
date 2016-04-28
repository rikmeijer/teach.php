<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFKLesweekToContactmomentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contactmoment', function(Blueprint $table)
		{
			$table->foreign(['jaar', 'kalenderweek'], 'fk_contactmomentlesweek')->references(['jaar', 'kalenderweek'])->on('lesweek')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contactmoment', function(Blueprint $table)
		{
			$table->dropForeign('fk_contactmomentlesweek');
		});
	}

}
