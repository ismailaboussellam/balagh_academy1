<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('groupe_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_teacher_id');
            $table->unsignedBigInteger('groupe_id');
            $table->timestamps();

            $table->foreign('user_teacher_id')->references('id')->on('user_teachers')->onDelete('cascade');
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groupe_teacher');
    }
};