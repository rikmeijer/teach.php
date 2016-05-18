<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentgroepcontactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('studentgroepcontact', function(Blueprint $table)
		{
			$table->integer('studentgroep_id');
			$table->integer('contactmoment_id')->index('contactmoment_idx');
			$table->primary(['studentgroep_id','contactmoment_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('studentgroepcontact');
	}

}
