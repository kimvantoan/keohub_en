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
        Schema::create('football_matches', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->unique()->nullable(); // ID từ bên thứ 3
            $table->string('home_team');
            $table->string('away_team');
            $table->string('home_logo')->nullable();
            $table->string('away_logo')->nullable();
            $table->dateTime('match_date');
            $table->string('status')->default('pending'); // pending, live, finished
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            
            // Prediction Data
            $table->text('expert_prediction')->nullable();
            $table->string('predicted_winner')->nullable(); // home, away, draw
            $table->integer('predicted_home_score')->nullable();
            $table->integer('predicted_away_score')->nullable();
            $table->string('odds_1x2')->nullable(); // Ví dụ: "1.50 - 4.20 - 5.10"
            
            $table->string('slug')->unique(); // vd: man-united-vs-arsenal-prediction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_matches');
    }
};
