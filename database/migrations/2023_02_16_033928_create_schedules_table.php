<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_home_id');
            $table->unsignedBigInteger('team_away_id');
            $table->string('day', 100);
            $table->time('time');
            $table->date('date');
            $table->char('pool', 1);
            $table->timestamps();

            $table->index('date');
            $table->foreign('team_home_id')->on('teams')->references('id')->cascadeOnDelete();
            $table->foreign('team_away_id')->on('teams')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
