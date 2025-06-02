<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('filier_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_teacher_id');
            $table->unsignedBigInteger('filier_id');
            $table->timestamps();

            $table->foreign('user_teacher_id')->references('id')->on('user_teachers')->onDelete('cascade');
            $table->foreign('filier_id')->references('id')->on('filiers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('filier_teacher');
    }
};