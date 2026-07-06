<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('building_countries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('country_id')->nullable();
            $table->string('name')->nullable();
            $table->string('active_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('building_countries');
    }
} 