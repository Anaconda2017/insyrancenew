<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalClaimCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_claim_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_role')->nullable();    
            $table->string('user_name')->nullable();
            $table->text('comment')->nullable();
            $table->string('comment_file')->nullable();
            $table->dateTime('comment_date')->nullable();
            $table->bigInteger('reciver_id')->nullable();
            $table->string('reciver_role')->nullable();
            $table->string('reciver_name')->nullable();
            $table->bigInteger('claim_id')->nullable();
            $table->string('claim_status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_claim_comments');
    }
} 