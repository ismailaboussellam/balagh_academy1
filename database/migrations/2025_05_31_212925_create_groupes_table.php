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
    Schema::create('groupes', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->unsignedBigInteger('filier_id');
        $table->timestamps();

        $table->foreign('filier_id')->references('id')->on('filiers')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
