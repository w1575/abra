<?php

namespace App\Data\ConversationSteps;

use Spatie\LaravelData\Data;

class EditStorageConversationData extends Data
{
    public function __construct(
        public int $cloud_storage_id,
        public string $step,
    ) {
    }
}
