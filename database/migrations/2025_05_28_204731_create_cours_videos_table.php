<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('cours_videos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cours_id');
        $table->string('description')->nullable();
        $table->string('video'); // Can store file path or YouTube link
        $table->timestamps();

        $table->foreign('cours_id')->references('id')->on('cours')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours_videos');
    }
};
