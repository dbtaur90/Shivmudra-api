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
        Schema::create('tbSabhasad', function (Blueprint $table) {
            $table->id('sabhasadID');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName');
            $table->date('dob');
            $table->string('gender');
            $table->string('bloodGroup');
            $table->boolean('married');
            $table->string('whatsappNumber');
            $table->string('mobileNumber');
            $table->string('email');
            $table->string('aadhar');
            $table->integer('permanentVillage', false, true);
            $table->string('permanentSubAddress');
            $table->boolean('isSameAddress');
            $table->integer('currentVillage', false, true);
            $table->string('currentSubAddress');
            $table->boolean('competitiveCandidate');
            $table->string('competitiveExamName');
            $table->string('educationID');
            $table->string('businessID');
            $table->boolean('isPoliticalBackground');
            $table->string('politcalPartyName');
            $table->string('politcalPartyPost');
            $table->boolean('isSocialBackground');
            $table->string('socialFoundationName');
            $table->string('socialFoundationPost');
            $table->string('helpForOrg');
            
            $table->timestamps();
        });

        Schema::table('tbSabhasad', function (Blueprint $table) {
            $table->foreign('businessID')->references('id')->on('tbSabhasadEmployment');
            $table->foreign('educationID')->references('id')->on('tbSabhasadEducation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sabhasad_models');
    }
};
