<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('medical_insurance_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('medical_insurance_number')->nullable();
            $table->string('admin_medical_insurance_number')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();
            $table->date('start_date')->nullable();
            $table->string('duration')->nullable();
            $table->date('end_date')->nullable();
            $table->string('active_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_requests');
    }
} 