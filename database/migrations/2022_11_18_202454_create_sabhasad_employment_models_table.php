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
        Schema::create('tbSabhasadEmployment', function (Blueprint $table) {
            $table->id();
            $table->string('employmentType'); 
            $table->string('businessArea'); 
            $table->string('businessmedicalSubArea'); 
            $table->string('businessDoctorSpecilization'); 
            $table->string('businessEngineeringBranch'); 
            $table->string('businessEducationPost'); 
            $table->string('businessEducationTeacherArea'); 
            $table->string('businessEducationTeacherMainSubject'); 
            $table->string('otherShopName'); 
            $table->string('otherShopType'); 
            $table->string('otherBusinessName'); 
            $table->string('otherServiceName'); 
            $table->string('employementArea'); 
            $table->string('employeeMedicalSubArea'); 
            $table->string('employeeMedicalHospitalPost'); 
            $table->string('employeeDoctorSpecilization'); 
            $table->string('employeeEngineeringBranch'); 
            $table->string('employeeEducationPost'); 
            $table->string('employeeEducationTeacherArea'); 
            $table->string('employeeEducationTeacherMainSubject'); 
            $table->string('employeePost'); 
            $table->string('employeeOtherPost'); 
            $table->string('traderArea'); 
            $table->string('agricultureMainCrops'); 
            $table->boolean('isAgricultureCumBusiness'); 
            $table->string('agricultureCumBusinessName'); 
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
        Schema::dropIfExists('sabhasad_employment_models');
    }
};
