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
			$table->integer('contactmoment_id')->index('fk_contactmomentrating_idx');
			$table->foreign('contactmoment_id')->references('id')->on('contactmoment');
			$table->enum('waarde', array('1','2','3','4','5'))->nullable();
			$table->text('inhoud', 65535);
			$table->timestamps();
			$table->softDeletes();
			
			$table->primary(['ipv4', 'contactmoment_id']);
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
