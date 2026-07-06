<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotorRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('motor_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('motor_insurance_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('motor_insurance_number')->nullable();
            $table->string('admin_motor_insurance_number')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();
            $table->bigInteger('car_type_id')->nullable();
            $table->string('car_type')->nullable();
            $table->bigInteger('car_brand_id')->nullable();
            $table->string('car_brand')->nullable();
            $table->bigInteger('car_model_id')->nullable();
            $table->string('car_model')->nullable();
            $table->bigInteger('car_year_id')->nullable();
            $table->string('car_year')->nullable();
            $table->decimal('car_price', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->string('duration')->nullable();
            $table->date('end_date')->nullable();
            $table->string('active_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('motor_requests');
    }
} 