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
        Schema::table('h_r_s', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('department')->nullable()->change();
            $table->integer('expected_salary')->nullable()->change();
            $table->integer('experience')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('reference')->nullable()->change();
            $table->string('interviewer')->nullable()->change();
            $table->date('interview_date')->nullable()->change();
            $table->integer('communication')->nullable()->change();
            $table->integer('english')->nullable()->change();
            $table->integer('computer_skills')->nullable()->change();
            $table->integer('confidence')->nullable()->change();
            $table->integer('learning_ability')->nullable()->change();
            $table->integer('dispatch_knowledge')->nullable()->change();
            $table->integer('negotiation_skills')->nullable()->change();
            $table->integer('typing_speed')->nullable()->change();
            $table->integer('total_score')->nullable()->change();
            $table->string('strengths')->nullable()->change();
            $table->string('weaknesses')->nullable()->change();
            $table->string('comments')->nullable()->change();
            $table->string('recommendation')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('h_r_s', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('department')->nullable(false)->change();
            $table->integer('expected_salary')->nullable(false)->change();
            $table->integer('experience')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('reference')->nullable(false)->change();
            $table->string('interviewer')->nullable(false)->change();
            $table->date('interview_date')->nullable(false)->change();
            $table->integer('communication')->nullable(false)->change();
            $table->integer('english')->nullable(false)->change();
            $table->integer('computer_skills')->nullable(false)->change();
            $table->integer('confidence')->nullable(false)->change();
            $table->integer('learning_ability')->nullable(false)->change();
            $table->integer('dispatch_knowledge')->nullable(false)->change();
            $table->integer('negotiation_skills')->nullable(false)->change();
            $table->integer('typing_speed')->nullable(false)->change();
            $table->integer('total_score')->nullable(false)->change();
            $table->string('strengths')->nullable(false)->change();
            $table->string('weaknesses')->nullable(false)->change();
            $table->string('comments')->nullable(false)->change();
            $table->string('recommendation')->nullable(false)->change();
        });
    }
};
