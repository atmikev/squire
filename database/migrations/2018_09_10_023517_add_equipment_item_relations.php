<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEquipmentItemRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->unsignedInteger('item_id')->after('character_id');
            $table->string('item_type')->after('item_id');

            $table->dropColumn('possessable_id');
            $table->dropColumn('possessable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn('item_id');
            $table->dropColumn('item_type');


            $table->unsignedInteger('possessable_id');
            $table->string('possessable_type');
        });

    }
}
