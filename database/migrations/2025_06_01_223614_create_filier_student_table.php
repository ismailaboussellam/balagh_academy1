<?php
// database/migrations/xxxx_xx_xx_create_filier_student_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilierStudentTable extends Migration
{
    public function up()
    {
        Schema::create('filier_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('filier_id');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('user_students')->onDelete('cascade');
            $table->foreign('filier_id')->references('id')->on('filiers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('filier_student');
    }
}