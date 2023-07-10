<?php

namespace App\Data\Storages\Common;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class DiskSpaceData extends Data
{
    #[Computed]
    public int $usedSpace;

    public function __construct(
        public int $space = 0,
        public int $freeSpace = 0,
    ) {
        $this->usedSpace = $this->space - $this->freeSpace;
    }
}
