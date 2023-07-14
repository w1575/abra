<?php

use App\Enums\Storages\StorageTypeEnum;
use App\Models\TelegramAccount;
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
        Schema::create('cloud_storages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->foreignIdFor(TelegramAccount::class)->constrained();
            $table->enum('storage_type', StorageTypeEnum::valuesList());
            $table->json('storage_settings')->nullable()->comment('Work settings');
            $table->json('access_config')->nullable()->comment('Api access config');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloud_storages');
    }
};
