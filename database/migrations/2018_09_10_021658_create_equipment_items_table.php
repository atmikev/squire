<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('equipment_category_id');
            $table->unsignedInteger('equipment_subcategory_id');
            $table->unsignedInteger('item_id');
            $table->string('item_type');

            $table->timestamps();

            $table->foreign('equipment_category_id')
                ->references('id')->on('equipment_categories')
                ->onDelete('CASCADE');

            $table->foreign('equipment_subcategory_id')
                ->references('id')->on('equipment_subcategories')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_items');
    }
}
