<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSofascoreAddColumnUpdatedScore extends Migration
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
                $table->integer('updated_score')->default(0)->index();
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
                $table->dropColumn('updated_score');
            }
        );
    }
}
