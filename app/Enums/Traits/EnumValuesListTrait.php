<?php

namespace App\Enums\Traits;

trait EnumValuesListTrait
{
    public static function valuesList(): array
    {
        return array_reduce(
            self::cases(),
            function ($carry, mixed $item) {
                $carry[] = $item->value;
                return $carry;
            },
            []
        );
    }
}
