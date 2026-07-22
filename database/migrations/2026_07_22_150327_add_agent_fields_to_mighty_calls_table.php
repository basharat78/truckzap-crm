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
        Schema::table('mighty_calls', function (Blueprint $table) {
            $table->string('agent_name')->nullable()->after('called_phone');
            $table->string('agent_extension')->nullable()->after('agent_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mighty_calls', function (Blueprint $table) {
            $table->dropColumn(['agent_name', 'agent_extension']);
        });
    }
};
