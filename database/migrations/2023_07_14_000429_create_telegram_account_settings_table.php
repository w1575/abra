<?php

use App\Models\CloudStorage;
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
        Schema::create('telegram_account_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('locale')->nullable()->comment('Язык системы для пользователя');
            $table->foreignIdFor(CloudStorage::class)->nullable()->comment('Хранилище по-умолчанию')->constrained()->onDelete('cascade');
            $table->foreignIdFor(TelegramAccount::class)->nullable()->constrained()->comment('Связанный аккаунт')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_account_settings');
    }
};
