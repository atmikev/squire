<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveEquipmentColumns extends Migration
{

    private $tables = [
        'armors',
        'adventuring_gears',
        'tools',
        'vehicles',
        'weapons',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {

            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['equipment_category_id']);
                $table->dropForeign(['equipment_subcategory_id']);

                $table->dropColumn('equipment_category_id');
                $table->dropColumn('equipment_subcategory_id');

            });

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        foreach ($this->tables as $table) {

            Schema::table($table, function (Blueprint $table) {
                $table->unsignedInteger('equipment_category_id');
                $table->unsignedInteger('equipment_subcategory_id');

                $table->foreign('equipment_category_id')
                    ->references('id')->on('equipment_categories')
                    ->onDelete('CASCADE');

                $table->foreign('equipment_subcategory_id')
                    ->references('id')->on('equipment_subcategories')
                    ->onDelete('CASCADE');
            });

        }

    }
}
