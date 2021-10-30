<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableScoresAddColumnEventDate extends Migration
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
                $table->string('event_date');
                $table->string('correct_score')->nullable();
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
                $table->dropColumn(['event_date', 'correct_score']);
            }
        );
    }
}
