<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_classes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->timestamps();
        });

        Schema::create('magic_schools', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->timestamps();
        });

        Schema::create('spells', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('magic_school_id');
            $table->string('name');
            $table->text('description');
            $table->text('higher_level')->nullable();
            $table->string('page');
            $table->string('range');
            $table->string('duration');
            $table->string('casting_time');
            $table->integer('level');

            $table->timestamps();

            $table->foreign('magic_school_id')
                ->references('id')->on('magic_schools')
                ->onDelete('cascade');
        });

        Schema::create('character_class_spell', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('character_class_id');
            $table->unsignedInteger('spell_id');

            $table->timestamps();

            $table->foreign('character_class_id')
                ->references('id')->on('character_classes')
                ->onDelete('cascade');

            $table->foreign('spell_id')
                ->references('id')->on('spells')
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
        Schema::dropIfExists('character_class_spell');
        Schema::dropIfExists('spells');
        Schema::dropIfExists('character_classes');
        Schema::dropIfExists('magic_schools');
    }
}
