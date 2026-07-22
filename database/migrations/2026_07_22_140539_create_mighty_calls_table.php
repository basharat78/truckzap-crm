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
        Schema::create('mighty_calls', function (Blueprint $table) {
            $table->id();
            $table->string('mightycall_call_id')->unique();
            
            $table->string('direction')->nullale();
            $table->string('call_status')->nullable();
            $table->string('business_number')->nullable();

            $table->string('caller_name')->nullable();
            $table->string('caller_phone')->nullable();
            $table->string('caller_extension')->nullable();

            $table->string('called_name')->nullable();
            $table->string('called_phone')->nullable();

            $table->unsignedInteger('duration_ms')->nullable();

             $table->string('recording_filename')->nullable();
             $table->text('recording_url')->nullable();        

           $table->timestamp('call_started_at')->nullable();  
           $table->timestamp('synced_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mighty_calls');
    }
};
