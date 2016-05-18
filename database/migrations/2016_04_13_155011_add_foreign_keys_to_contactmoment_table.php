<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContactmomentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contactmoment', function(Blueprint $table)
		{
			$table->foreign('les_id', 'fk_les')->references('id')->on('les')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
			$table->dropForeign('fk_les');
		});
	}

}
