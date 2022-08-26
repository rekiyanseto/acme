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
        Schema::create('initial_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('initial_test_tool');
            $table->string('initial_test_result');
            $table->string('initial_test_standard');
            $table->text('initial_test_note')->nullable();
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
        Schema::dropIfExists('initial_tests');
    }
};
