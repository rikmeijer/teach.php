<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActiviteitmediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activiteitmedia', function(Blueprint $table)
		{
			$table->foreign('activiteit_id', 'fk_activiteitmedia')->references('id')->on('activiteit')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('media_id', 'fk_activiteitmedia_media')->references('id')->on('media')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activiteitmedia', function(Blueprint $table)
		{
			$table->dropForeign('fk_activiteitmedia');
			$table->dropForeign('fk_activiteitmedia_media');
		});
	}

}
