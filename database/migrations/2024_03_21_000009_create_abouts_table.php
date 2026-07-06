<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutsTable extends Migration
{
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('en_title')->nullable();
            $table->string('ar_title')->nullable();
            $table->string('en_slug')->nullable();
            $table->string('ar_slug')->nullable();
            $table->text('en_description')->nullable();
            $table->text('ar_description')->nullable();
            $table->string('image')->nullable();
            $table->string('en_meta_title')->nullable();
            $table->string('ar_meta_title')->nullable();
            $table->text('en_meta_description')->nullable();
            $table->text('ar_meta_description')->nullable();
            $table->string('active_status')->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('abouts');
    }
} 