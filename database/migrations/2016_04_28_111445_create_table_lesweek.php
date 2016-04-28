<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLesweek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('lesweek', function(Blueprint $table)
		{
			$table->string('jaar', 4);
			$table->string('kalenderweek', 2);
			$table->string('onderwijsweek', 2);
			$table->string('blokweek', 2);
			$table->primary(['jaar', 'kalenderweek'], 'weekjaar');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('lesweek');
    }
}
