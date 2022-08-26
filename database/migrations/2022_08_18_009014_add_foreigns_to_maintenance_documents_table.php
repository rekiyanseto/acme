<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenance_documents', function (Blueprint $table) {
            $table
                ->foreign('sub_area_id')
                ->references('id')
                ->on('sub_areas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('equipment_id')
                ->references('id')
                ->on('equipment')
                ->onUpdate('CASCADE')
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
        Schema::table('maintenance_documents', function (Blueprint $table) {
            $table->dropForeign(['sub_area_id']);
            $table->dropForeign(['equipment_id']);
        });
    }
};
