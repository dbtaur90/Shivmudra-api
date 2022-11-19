<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbSabhasadDocument', function (Blueprint $table) {
            $table->id();
            $table->string('sabhasadID');
            $table->string('aadharImage');
            $table->string('tcImage');
            $table->string('photoImage');
            $table->string('signImage');
            $table->timestamps();
        });

        Schema::table('tbSabhasad', function (Blueprint $table) {
            $table->foreign('sabhasadID')->references('sabhasadID')->on('tbSabhasad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sabhasad_document_models');
    }
};
