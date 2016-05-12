<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnJaarKalenderweekToLesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('les', function(Blueprint $table)
		{
			$table->string('jaar', 4);
			$table->string('kalenderweek', 2);
		});
		
		DB::statement("
		    UPDATE les
		    SET 
		      les.jaar = '2016', 
		      les.kalenderweek = '1'
		");
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
			$table->dropColumn('jaar');
			$table->dropColumn('kalenderweek');
		});
	}

}
