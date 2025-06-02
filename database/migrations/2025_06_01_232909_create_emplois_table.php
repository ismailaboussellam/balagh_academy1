<?php
// database/migrations/xxxx_xx_xx_create_emplois_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploisTable extends Migration
{
    public function up()
    {
        Schema::create('emplois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('groupe_id');
            $table->unsignedBigInteger('prof_id');
            $table->string('module');
            $table->string('salle')->nullable();
            $table->enum('type', ['etablissement', 'distance'])->default('etablissement');
            $table->string('jour'); // ex: LUNDI, MARDI...
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->integer('semaine'); // رقم الأسبوع
            $table->timestamps();

            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
            $table->foreign('prof_id')->references('id')->on('user_teachers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emplois');
    }
}