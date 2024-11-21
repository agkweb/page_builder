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
        Schema::create('quiz_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreignId('question_id');
            $table->foreign('question_id')->references('id')->on('quiz_questions')->onDelete('cascade');
            $table->foreignId('answer_id');
            $table->foreign('answer_id')->references('id')->on('quiz_options')->onDelete('cascade');
            $table->tinyInteger('status');
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_responses');
    }
};
