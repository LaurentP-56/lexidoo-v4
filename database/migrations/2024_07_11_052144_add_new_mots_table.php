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
        Schema::create('mots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('theme_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('level_id');
            $table->string('nom');
            $table->string('traduction');
            $table->string('commentaire');
            $table->string('audio');
            $table->string('gratuit');
            $table->string('probability_of_appearance');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('theme_id')
                ->references('id')
                ->on('themes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('sub_category_id')
                ->references('id')
                ->on('sub_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('level_id')
                ->references('id')
                ->on('levels')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mots');
    }
};