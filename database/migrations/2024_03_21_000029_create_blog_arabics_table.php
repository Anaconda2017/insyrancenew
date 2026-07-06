<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArabicsTable extends Migration
{
    public function up()
    {
        Schema::create('blog_arabics', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('author')->nullable();
            $table->date('publish_date')->nullable();
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
        Schema::dropIfExists('blog_arabics');
    }
} 