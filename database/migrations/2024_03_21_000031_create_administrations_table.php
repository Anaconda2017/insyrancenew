<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministrationsTable extends Migration
{
    public function up()
    {
        Schema::create('adminstrations', function (Blueprint $table) {
            $table->id();
            $table->string('en_name')->nullable();
            $table->string('ar_name')->nullable();
            $table->string('en_job')->nullable();
            $table->string('ar_job')->nullable();
            $table->string('admin_image')->nullable();
            $table->string('active_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adminstrations');
    }
} 