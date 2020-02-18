<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertCompositeKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'lesweken',
            function (Blueprint $table) {
                $table->unsignedBigInteger('id');
            }
        );
        Schema::table(
            'lessen',
            function (Blueprint $table) {
                $table->unsignedBigInteger('lesweek_id');
            }
        );

        $lesweken = DB::table('lesweken')->get();
        foreach ($lesweken as $index => $lesweek) {
            DB::statement('UPDATE lesweken SET lessen.lesweek_id = ' . $index);
        }
        DB::statement(
            'UPDATE lessen JOIN lesweken ON lessen.jaar = lesweken.jaar AND lessen.kalenderweek = lesweken.kalenderweek SET lessen.lesweek_id = lesweken.id'
        );


        Schema::table(
            'lessen',
            function (Blueprint $table) {
                $table->dropForeign('lessen_jaar_kalenderweek_foreign');
                $table->dropColumn(['jaar', 'kalenderweek']);
            }
        );
        Schema::table(
            'lesweken',
            function (Blueprint $table) {
                $table->dropPrimary();
                $table->unique(['jaar', 'kalenderweek']);
                $table->primary('id');
            }
        );
        Schema::table(
            'lesweken',
            function (Blueprint $table) {
                $table->bigIncrements('id')->change();
            }
        );
        Schema::table(
            'lessen',
            function (Blueprint $table) {
                $table->foreign('lesweek_id')->references('id')->on('lesweken');
            }
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'lessen',
            function (Blueprint $table) {
                $table->string('jaar', 4);
                $table->string('kalenderweek', 2);
            }
        );


        DB::statement(
            'UPDATE lessen JOIN lesweken ON lessen.lesweek_id = lesweken.id SET lessen.jaar = lesweken.jaar, lessen.kalenderweek = lesweken.kalenderweek'
        );

        Schema::table(
            'lessen',
            function (Blueprint $table) {
                $table->dropForeign('lessen_lesweek_id_foreign');
                $table->dropColumn('lesweek_id');
            }
        );

        Schema::table(
            'lesweken',
            function (Blueprint $table) {
                $table->dropColumn('id');
                $table->primary(['jaar', 'kalenderweek']);
            }
        );

        Schema::table(
            'lessen',
            function (Blueprint $table) {
                $table->foreign(['jaar', 'kalenderweek'])->references(['jaar', 'kalenderweek'])->on('lesweken');
            }
        );
    }
}
