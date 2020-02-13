<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModulesLookupData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    final public function up(): void
    {
        $modules = ["AFST", "DATAB1", "DATAB2", "DATAB3", "DATAB4", "DPA", "LAO", "MODL3", "PROG1", "PROG2", "PROG3", "PROG4", "REGEX", "SEC2", "SLC05", "SOPRJ3", "SOPRJ4", "SOPRJ5", "SOPRJ6", "STAGE", "SWAPRJ13", "SWAPRJ14", "SWEN1", "SWEN2", "VDATAB2", "VPROG1", "VPROG2", "VSLCO", "VSOPRJ2", "WEBS2", "WEBS5"];
        foreach ($modules as $module) {
            DB::table('modules')->insert(['naam' => $module]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    final public function down(): void
    {
        DB::table('modules')->truncate();
    }
}
