<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nummer', 7)->nullable()->unique('nummer');
			$table->string('roepnaam', 50)->nullable();
			$table->string('tussenvoegsel', 10)->nullable();
			$table->string('achternaam', 50)->nullable();
			$table->integer('studentgroep_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('student');
	}

}
