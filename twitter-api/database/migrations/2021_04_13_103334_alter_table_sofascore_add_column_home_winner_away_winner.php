<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSofascoreAddColumnHomeWinnerAwayWinner extends Migration
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
                $table->boolean('winner_home')->default(false);
                $table->boolean('winner_away')->default(false);
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
            'sofascores',
            function (Blueprint $table) {
                $table->dropColumn(['winner_home', 'winner_away']);
            }
        );
    }
}
