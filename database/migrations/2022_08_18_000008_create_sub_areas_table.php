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
        Schema::create('sub_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sub_area_name');
            $table->string('sub_area_code')->unique();
            $table->text('sub_area_description')->nullable();
            $table->string('sub_area_site_plan')->nullable();
            $table->string('maintenance_by')->nullable();
            $table->unsignedBigInteger('area_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_areas');
    }
};
