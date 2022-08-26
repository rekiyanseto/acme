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
        Schema::create('maintenance_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document_name');
            $table->text('document_remarks')->nullable();
            $table->string('document_file');
            $table->unsignedBigInteger('sub_area_id')->nullable();
            $table->unsignedBigInteger('equipment_id')->nullable();

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
        Schema::dropIfExists('maintenance_documents');
    }
};
