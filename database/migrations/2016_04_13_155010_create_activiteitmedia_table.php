<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActiviteitmediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activiteitmedia', function(Blueprint $table)
		{
			$table->integer('activiteit_id')->index('fk_activiteitmedia_idx');
			$table->integer('media_id')->index('fk_activiteitmedia_media_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activiteitmedia');
	}

}
