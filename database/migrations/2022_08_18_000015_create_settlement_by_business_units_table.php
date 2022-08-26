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
        Schema::create('settlement_by_business_units', function (
            Blueprint $table
        ) {
            $table->bigIncrements('id');
            $table->text('note')->nullable();
            $table->string('spk_no');
            $table->integer('progress');
            $table->string('photo')->nullable();
            $table->string('condition');
            $table->unsignedBigInteger('survey_id');

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
        Schema::dropIfExists('settlement_by_business_units');
    }
};
