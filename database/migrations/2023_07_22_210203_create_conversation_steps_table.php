<?php

use App\Models\TelegramAccount;
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
        Schema::create('conversation_steps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(TelegramAccount::class)->constrained();
            $table->string('conversation_name')->comment('Name of the conversation');
            $table->json('step_data')->nullable()->comment('Example: {id: 12, step: edit_name}');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_steps');
    }
};
