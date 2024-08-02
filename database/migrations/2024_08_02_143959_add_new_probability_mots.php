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
        Schema::table('user_word_probabilities', function (Blueprint $table) {
            $table->string('know_level')->nullable()->after('probability_of_appearance');
            $table->string('dont_know_level')->nullable()->after('know_level');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_word_probabilities', function (Blueprint $table) {
            $table->dropColumn('know_level');
            $table->dropColumn('dont_know_level');
        });

    }
};
