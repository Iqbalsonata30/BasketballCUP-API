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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teams_id');
            $table->unsignedBigInteger('total_win')->default(0);
            $table->unsignedBigInteger('total_lose')->default(0);
            $table->bigInteger('winrate')->default(0);
            $table->unsignedBigInteger('total_match')->default(0);
            $table->enum('gender', ['Putra', 'Putri']);
            $table->char('pool',1)->default('N');
            $table->timestamps();
            $table->foreign('teams_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standings');
    }
};
