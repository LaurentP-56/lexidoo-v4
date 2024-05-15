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
        Schema::table('mots', function (Blueprint $table) {
            $table->unsignedBigInteger('theme_id')->nullable()->after('level_id');
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mots', function (Blueprint $table) {
            //
        });
    }
};
