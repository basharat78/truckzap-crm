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
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();
            //Company Information
            $table->string('dispatcher_name');
            $table->string('company_name');
            $table->string('mc_number')->unique();
            $table->string('dot_number');
            $table->string('website')->nullable();
            $table->enum('status', ['active', 'inactive', 'blacklisted', 'pending'])->default('pending');
            //Contact Information
            $table->string('name');
            $table->string('department')->nullable();
            $table->string('email')->unique();
            $table->string('phone');
            //Address Information
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');

            $table->json('equipment_type');
            $table->json('operating_states');

            $table->string('credit_score')->nullable();
            $table->integer('days_to_pay')->nullable();

            $table->text('notes')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brokers');
    }
};
