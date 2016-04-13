<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToThemaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('thema', function(Blueprint $table)
		{
			$table->foreign('conceptualiseren_id', 'fk_conceptualiseren')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('ervaren_id', 'fk_ervaren')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('les_id', 'fk_lesthema')->references('id')->on('les')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('reflecteren_id', 'fk_reflecteren')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('toepassen_id', 'fk_toepassen')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('thema', function(Blueprint $table)
		{
			$table->dropForeign('fk_conceptualiseren');
			$table->dropForeign('fk_ervaren');
			$table->dropForeign('fk_lesthema');
			$table->dropForeign('fk_reflecteren');
			$table->dropForeign('fk_toepassen');
		});
	}

}
