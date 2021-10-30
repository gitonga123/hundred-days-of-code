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
                $table->string('home_odd')->nullable();
                $table->string('away_odd')->nullable();
                $table->string('home_change')->nullable();
                $table->string('away_change')->nullable();
                $table->string('expected_value_home')->nullable();
                $table->string('actual_value_home')->nullable();
                $table->string('expected_value_away')->nullable();
                $table->string('actual_value_away')->nullable();
                $table->string('result');
                $table->text('home_score');
                $table->text('away_score');
                $table->string('match_id');
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
