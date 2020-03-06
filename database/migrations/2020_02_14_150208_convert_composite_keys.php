<?php
declare(strict_types=1);

use App\Les;
use App\Lesweek;
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
    final public function up(): void
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

        /* @var $lesweken Lesweek[] */
        $lesweken = DB::table('lesweken')->get();
        foreach ($lesweken as $index => $lesweek) {
            $lesweek->update(['id' => $index]);

            /* @var $lessen Les[] */
            DB::table('lesweken')->where(
                [
                    'kalenderweek' => $lesweek->kalenderweek,
                    'jaar' => $lesweek->jaar
                ]
            )->update(['lesweek_id' => $lesweek->id]);
        }

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
    final public function down(): void
    {
        Schema::table(
            'lessen',
            function (Blueprint $table) {
                $table->string('jaar', 4);
                $table->string('kalenderweek', 2);
            }
        );

        /* @var $lesweken Lesweek[] */
        $lesweken = DB::table('lesweken')->get();
        foreach ($lesweken as $index => $lesweek) {
            $lesweek->lessen()->update(
                [
                    'kalenderweek' => $lesweek->kalenderweek,
                    'jaar' => $lesweek->jaar
                ]
            );
        }

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
