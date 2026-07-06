<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotorInsurancesTable extends Migration
{
    public function up()
    {
        Schema::create('motor_insurances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('en_title')->nullable();
            $table->string('ar_title')->nullable();
            $table->decimal('year_money', 10, 2)->nullable();
            $table->decimal('month_money', 10, 2)->nullable();
            $table->string('company_name')->nullable();
            $table->string('active_status')->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('motor_insurances');
    }
} 