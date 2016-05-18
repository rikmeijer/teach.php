<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('les', function(Blueprint $table)
		{
			$table->foreign('evaluatie_id', 'fk_evaluatie')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('huiswerk_id', 'fk_huiswerk')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('kennismaken_id', 'fk_kennismaken')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('module_id', 'fk_leergang')->references('id')->on('module')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('doelgroep_id', 'fk_lesdoelgroep')->references('id')->on('doelgroep')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('pakkend_slot_id', 'fk_pakkend_slot')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('terugblik_id', 'fk_terugblik')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('voorstellen_id', 'fk_voorstellen')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
			$table->dropForeign('fk_evaluatie');
			$table->dropForeign('fk_huiswerk');
			$table->dropForeign('fk_kennismaken');
			$table->dropForeign('fk_leergang');
			$table->dropForeign('fk_lesdoelgroep');
			$table->dropForeign('fk_pakkend_slot');
			$table->dropForeign('fk_terugblik');
			$table->dropForeign('fk_voorstellen');
		});
	}

}
