<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarYearsTable extends Migration
{
    public function up()
    {
        Schema::create('car_years', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('car_model_id')->nullable();
            $table->string('year')->nullable();
            $table->string('active_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_years');
    }
} 