<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingTypesTable extends Migration
{
    public function up()
    {
        Schema::create('building_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('active_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('building_types');
    }
} 