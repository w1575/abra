<?php

namespace App\Enums\TelegramAccount;

use App\Enums\Traits\EnumValuesListTrait;

enum StatusEnum: string
{

    use EnumValuesListTrait;

    case NotLinked = 'Not Linked';

    case Inactive = 'Inactive';

    case Active = 'Active';

    case Blocked = 'Blocked';

    case Deleted = 'Deleted';
}
