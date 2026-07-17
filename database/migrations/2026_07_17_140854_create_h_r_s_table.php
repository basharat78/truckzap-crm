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
        Schema::create('h_r_s', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('phone');
            $table->string('email');
            $table->string('position');
            $table->string('department');
            $table->integer('expected_salary');
            $table->integer('experience');
            $table->string('city');
            $table->string('reference');
            $table->string('interviewer');
            $table->date('interview_date');
            $table->integer('communication');
            $table->integer('english');
            $table->integer('computer_skills');
            $table->integer('confidence');
            $table->integer('learning_ability');
            $table->integer('dispatch_knowledge');
            $table->integer('negotiation_skills');
         
            $table->integer('typing_speed');
            $table->integer('total_score');
            $table->string('strengths');
            $table->string('weaknesses');
            $table->string('comments');
            $table->string('recommendation');
            $table->enum('status',['pending','selected','rejected','on_hold'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_r_s');
    }
};
