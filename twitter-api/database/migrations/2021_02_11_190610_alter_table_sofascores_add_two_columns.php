<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSofascoresAddTwoColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'sofascores',
            function (Blueprint $table) {
                $table->string('home_total')->default(0);
                $table->string('away_total')->default(0);
                $table->string('both_total')->default(0);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'sofascores',
            function (Blueprint $table) {
                $table->dropColumn('home_total', 'away_total', 'both_total');
            }
        );
    }
}
