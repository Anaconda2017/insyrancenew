<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotorInsuranceChoicesTable extends Migration
{
    public function up()
    {
        Schema::create('motor_insurance_choices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('motor_insurance_id')->nullable();
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
        Schema::dropIfExists('motor_insurance_choices');
    }
} 