<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ability_scores', function (Blueprint $table){
            $table->increments('id');

            $table->integer('strength')->nullable(false);
            $table->integer('dexterity')->nullable(false);
            $table->integer('constitution')->nullable(false);
            $table->integer('intelligence')->nullable(false);
            $table->integer('wisdom')->nullable(false);
            $table->integer('charisma')->nullable(false);

            $table->timestamps();
        });

        Schema::create('character_stats', function (Blueprint $table){
            $table->increments('id');

            $table->unsignedInteger('ability_score_id')->nullable(false);

            $table->timestamps();

            $table->foreign('ability_score_id')
                ->references('id')->on('ability_scores')
                ->onDelete('cascade');
        });

        Schema::create('characters', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('character_stat_id')->nullable(false);
            $table->string('name')->nullable(false);

            $table->timestamps();

            $table->foreign('character_stat_id')
                ->references('id')->on('character_stats')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
        Schema::dropIfExists('character_stats');
        Schema::dropIfExists('ability_scores');
    }
}
