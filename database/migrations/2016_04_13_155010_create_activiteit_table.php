<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActiviteitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activiteit', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('werkvorm', 45);
			$table->enum('organisatievorm', array('plenair','groepswerk','circuit'));
			$table->enum('werkvormsoort', array('ijsbreker','discussie','docent gecentreerd','werkopdracht','individuele werkopdracht'));
			$table->integer('tijd');
			$table->simple_array('intelligenties')->nullable();
			$table->text('inhoud', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activiteit');
	}

}
