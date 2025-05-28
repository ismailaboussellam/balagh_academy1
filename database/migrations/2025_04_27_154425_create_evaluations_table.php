<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
            Schema::create('evaluations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->integer('rating')->unsigned()->between(1, 5);
                $table->text('comment')->nullable();
                $table->timestamps();
            });
        }

    public function down()
        {
            Schema::dropIfExists('evaluations');
        }
};
