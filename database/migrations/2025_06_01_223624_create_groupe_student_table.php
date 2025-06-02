<?php
// database/migrations/xxxx_xx_xx_create_groupe_student_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupeStudentTable extends Migration
{
    public function up()
    {
        Schema::create('groupe_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('groupe_id');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('user_students')->onDelete('cascade');
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groupe_student');
    }
}