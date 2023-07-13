<?php

namespace App\Enums\Bot;

use App\Enums\Traits\EnumValuesListTrait;

enum FileTypeEnum: string
{
    use EnumValuesListTrait;

    case Video = 'Video';
    case Photo = 'Photo';
    case Audio = 'Audio';
    case Animation = 'Animation';
    case Voice = 'Voice';
    case Sticker = 'Sticker';
    case VideoNote = 'VideoNote';
}
