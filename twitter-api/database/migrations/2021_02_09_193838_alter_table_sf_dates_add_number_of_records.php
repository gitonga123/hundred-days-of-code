<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSfDatesAddNumberOfRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'sf_dates',
            function (Blueprint $table) {
                $table->integer('number_of_records')->nullable();
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
            'sf_dates',
            function (Blueprint $table) {
                $table->dropColumn('number_of_records');
            }
        );
    }
}
