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
            $table->integer('experience')->nullable();
            $table->string('city')->nullable();
            $table->string('reference')->nullable();
            $table->string('interviewer');
            $table->date('interview_date');
            $table->integer('communication')->nullable();
            $table->integer('english')->nullable();
            $table->integer('computer_skills')->nullable();
            $table->integer('confidence')->nullable();
            $table->integer('learning_ability')->nullable();
            $table->integer('dispatch_knowledge')->nullable();
            $table->integer('negotiation_skills')->nullable();
         
            $table->integer('typing_speed')->nullable();
            $table->integer('total_score')->nullable();
            $table->string('strengths')->nullable();
            $table->string('weaknesses')->nullable();
            $table->string('comments')->nullable();
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
