<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSofascoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'sofascores',
            function (Blueprint $table) {
                $table->id();
                $table->string('competition');
                $table->string('player_1');
                $table->string('player_2');
                $table->string('home_odd');
                $table->string('away_odd');
                $table->string('home_change');
                $table->string('away_change');
                $table->string('expected_value_home');
                $table->string('actual_value_home');
                $table->string('expected_value_away');
                $table->string('actual_value_away');
                $table->string('result');
                $table->string('score');
                $table->timestamps();
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
        Schema::dropIfExists('sofascores');
    }
}
