<?php

use App\Enums\TelegramAccount\StatusEnum;
use App\Models\User;
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
        Schema::create('telegram_accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('telegram_id')->unique()->nullable();
            $table->string('username')->nullable();
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('token')->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->enum('status', StatusEnum::valuesList());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_accounts');
    }
};
