<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('amount', 255);
            $table->unsignedBigInteger('recipe_id');
            $table->timestamps();
            $table->foreign('recipe_id')->references('id')->on('recipes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
