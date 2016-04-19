<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('rating', function(Blueprint $table)
		{
			$table->string('ipv4', 15);
			$table->integer('les_id')->index('fk_lesrating_idx');
			$table->foreign('les_id')->references('id')->on('les');
			$table->enum('value', array('1','2','3','4','5'))->nullable();
			$table->text('inhoud', 65535);
			$table->timestamps();
			$table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('rating');
    }
}
