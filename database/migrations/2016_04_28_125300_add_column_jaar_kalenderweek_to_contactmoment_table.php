<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnJaarKalenderweekToContactmomentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contactmoment', function(Blueprint $table)
		{
			$table->string('jaar', 4);
			$table->string('kalenderweek', 2);
		});

		DB::statement("
		    UPDATE contactmoment
		    SET 
		      contactmoment.jaar = YEAR(contactmoment.starttijd),
		      contactmoment.kalenderweek = WEEKOFYEAR(contactmoment.starttijd)
		");
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
			$table->dropColumn('jaar');
			$table->dropColumn('kalenderweek');
		});
	}

}
