<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactMomentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    final public function up(): void
    {
        //CREATE TABLE lesweek (
        //jaar VARCHAR(4) NOT NULL COLLATE utf8_unicode_ci,
        // kalenderweek VARCHAR(2) NOT NULL COLLATE utf8_unicode_ci,
        // onderwijsweek VARCHAR(2) DEFAULT NULL COLLATE utf8_unicode_ci,
        // blokweek VARCHAR(2) DEFAULT NULL COLLATE utf8_unicode_ci,
        // PRIMARY KEY(jaar, kalenderweek))
        // DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = ''
        Schema::create(
            'lesweken',
            function (Blueprint $table) {
                $table->string('jaar', 4);
                $table->string('kalenderweek', 2);
                $table->primary(['jaar', 'kalenderweek']);

                $table->string('onderwijsweek', 2);
                $table->string('blokweek', 2);
            }
        );

        //CREATE TABLE les (
        //id INT AUTO_INCREMENT NOT NULL,
        // jaar VARCHAR(4) NOT NULL COLLATE utf8_unicode_ci,
        // kalenderweek VARCHAR(2) NOT NULL COLLATE utf8_unicode_ci,
        // module_naam VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci,
        // naam TEXT NOT NULL COLLATE utf8_unicode_ci,
        // opmerkingen TEXT DEFAULT NULL COLLATE utf8_unicode_ci,
        // created_at DATETIME DEFAULT NULL,
        // updated_at DATETIME DEFAULT NULL,
        // INDEX fk_leslesweek (jaar, kalenderweek),
        // INDEX fk_lesmodule (module_naam),
        // PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = ''
        Schema::create(
            'lessen',
            function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('jaar', 4);
                $table->string('kalenderweek', 2);
                $table->foreign(['jaar', 'kalenderweek'])->references(['jaar', 'kalenderweek'])->on('lesweken');

                $table->string('module_naam', 10);
                $table->foreign('module_naam')->references('naam')->on('modules');

                $table->timestamps();
            }
        );

        //CREATE TABLE contactmoment (
        //id INT AUTO_INCREMENT NOT NULL,
        // les_id INT NOT NULL,
        // owner VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, -->user_id
        // starttijd DATETIME NOT NULL,
        // eindtijd DATETIME NOT NULL,
        // ruimte TEXT DEFAULT NULL COLLATE utf8_unicode_ci, -->locatie
        // ical_uid VARCHAR(250) NOT NULL COLLATE utf8_unicode_ci,
        // created_at DATETIME DEFAULT NULL,
        // updated_at DATETIME DEFAULT NULL,
        // UNIQUE INDEX ical_uid (ical_uid),
        // UNIQUE INDEX starttijd (starttijd),
        // INDEX IDX_929E7431CF60E67C (owner),
        // INDEX fk_contactmoment_les (les_id),
        // PRIMARY KEY(id))
        // DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = ''
        Schema::create(
            'contactmomenten',
            function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->unsignedBigInteger('les_id');
                $table->foreign('les_id')->references('id')->on('lessen');

                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');

                $table->dateTime('starttijd');
                $table->dateTime('eindtijd');
                $table->text('locatie');

                $table->string('ical_uid')->unique();

                $table->timestamps();
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
        Schema::dropIfExists('contactmomenten');
        Schema::dropIfExists('lessen');
        Schema::dropIfExists('lesweken');
    }
}
