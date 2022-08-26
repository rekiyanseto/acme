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
        Schema::create('functional_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('functional_location_name');
            $table->string('functional_location_code')->unique();
            $table->string('functional_location_site_plan')->nullable();
            $table->unsignedBigInteger('business_unit_id');

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
        Schema::dropIfExists('functional_locations');
    }
};
