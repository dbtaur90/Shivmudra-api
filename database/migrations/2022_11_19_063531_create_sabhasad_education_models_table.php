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
        Schema::create('tbSabhasadEducation', function (Blueprint $table) {
            $table->id();
            $table->string('educationClass');
            $table->string('educationITIBranch');
            $table->string('phdArea');
            $table->string('phdMainSubject');
            $table->string('phdResearchDetail');
            $table->string('educationDegreeType');
            $table->string('educationDegreeBranch');
            $table->string('educationDegreeBranchOther');
            $table->string('educationDegreeArea');
            $table->string('educationDegreeAreaOther');
            $table->string('educationDegreeNonEngineering');
            $table->string('isEducationCompleted');
            $table->string('educationBranchEngineering');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sabhasad_education_models');
    }
};
