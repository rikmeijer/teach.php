<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContactmomentAddEventUID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('contactmoment', function(Blueprint $table)
		{
		    $table->text('ical_uid')->nullable();
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
		    $table->dropColumn('ical_uid');
		});
    }
}
