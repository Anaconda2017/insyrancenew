<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingInsuranceChoicesTable extends Migration
{
    public function up()
    {
        Schema::create('building_insurance_choices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('building_insurance_id')->nullable();
            $table->string('en_title')->nullable();
            $table->string('ar_title')->nullable();
            $table->text('en_description')->nullable();
            $table->text('ar_description')->nullable();
            $table->string('active_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('building_insurance_choices');
    }
} 