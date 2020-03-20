<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('dice', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->integer('min_value');
            $table->integer('max_value');

            $table->timestamps();
        });

        Schema::create('damage_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('description');

            $table->timestamps();
        });

        Schema::create('damages', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('damage_type_id');
            $table->unsignedInteger('dice_id');
            $table->integer('dice_count');

            $table->timestamps();

            $table->foreign('damage_type_id')
                ->references('id')->on('damage_types')
                ->onDelete('cascade');

            $table->foreign('dice_id')
                ->references('id')->on('dice')
                ->onDelete('cascade');
        });

        Schema::create('equipment_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->timestamps();
        });

        Schema::create('equipment_subcategories', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('equipment_category_id');
            $table->string('name');

            $table->timestamps();

            $table->foreign('equipment_category_id')
                ->references('id')->on('equipment_categories')
                ->onDelete('cascade');
        });

        Schema::create('weapons', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('damage_id');
            $table->unsignedInteger('equipment_category_id');
            $table->unsignedInteger('equipment_subcategory_id');
            $table->string('name');
            $table->float('weight');

            $table->timestamps();

            $table->foreign('damage_id')
                ->references('id')->on('damages')
                ->onDelete('cascade');

            $table->foreign('equipment_category_id')
                ->references('id')->on('equipment_categories')
                ->onDelete('cascade');

            $table->foreign('equipment_subcategory_id')
                ->references('id')->on('equipment_subcategories')
                ->onDelete('cascade');
        });

        Schema::create('armor_classes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('base');
            $table->integer('dex_bonus');
            $table->integer('max_bonus')->nullable();

            $table->timestamps();

        });

        Schema::create('armors', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('equipment_category_id');
            $table->unsignedInteger('equipment_subcategory_id');
            $table->unsignedInteger('armor_class_id');
            $table->string('name');
            $table->integer('str_minimum');
            $table->boolean('stealth_disadvantage');
            $table->float('weight');

            $table->timestamps();

            $table->foreign('equipment_category_id')
                ->references('id')->on('equipment_categories')
                ->onDelete('cascade');

            $table->foreign('equipment_subcategory_id')
                ->references('id')->on('equipment_subcategories')
                ->onDelete('cascade');

            $table->foreign('armor_class_id')
                ->references('id')->on('armor_classes')
                ->onDelete('cascade');

        });

        Schema::create('adventuring_gears', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('equipment_category_id');
            $table->unsignedInteger('equipment_subcategory_id');
            $table->string('name');
            $table->float('weight');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('equipment_category_id')
                ->references('id')->on('equipment_categories')
                ->onDelete('cascade');

            $table->foreign('equipment_subcategory_id')
                ->references('id')->on('equipment_subcategories')
                ->onDelete('cascade');

        });

        Schema::create('tools', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('equipment_category_id');
            $table->unsignedInteger('equipment_subcategory_id');
            $table->string('name');
            $table->float('weight');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('equipment_category_id')
                ->references('id')->on('equipment_categories')
                ->onDelete('cascade');

            $table->foreign('equipment_subcategory_id')
                ->references('id')->on('equipment_subcategories')
                ->onDelete('cascade');

        });

        Schema::create('vehicles', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('equipment_category_id');
            $table->unsignedInteger('equipment_subcategory_id');
            $table->string('name');
            $table->integer('speed')->nullable();
            $table->float('capacity')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('equipment_category_id')
                ->references('id')->on('equipment_categories')
                ->onDelete('cascade');

            $table->foreign('equipment_subcategory_id')
                ->references('id')->on('equipment_subcategories')
                ->onDelete('cascade');

        });

        $this->populateDice();
    }

    private function populateDice() {
        $now = new DateTime();

        DB::table('dice')->insert(
            array(
                'name' => 'd0',
                'min_value' => 0,
                'max_value' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd1',
                'min_value' => 1,
                'max_value' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd4',
                'min_value' => 1,
                'max_value' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd6',
                'min_value' => 1,
                'max_value' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd8',
                'min_value' => 1,
                'max_value' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd10',
                'min_value' => 1,
                'max_value' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd12',
                'min_value' => 1,
                'max_value' => 12,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd20',
                'min_value' => 1,
                'max_value' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('dice')->insert(
            array(
                'name' => 'd100',
                'min_value' => 1,
                'max_value' => 100,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weapons');
        Schema::dropIfExists('damages');
        Schema::dropIfExists('damage_types');
        Schema::dropIfExists('dice');
        Schema::dropIfExists('tools');
        Schema::dropIfExists('armors');
        Schema::dropIfExists('armor_classes');
        Schema::dropIfExists('adventuring_gears');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('equipment_subcategories');
        Schema::dropIfExists('equipment_categories');
    }
}
