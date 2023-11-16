<?php

namespace Wovosoft\BkbOffices\Enums;

use Wovosoft\LaravelCommon\Traits\HasEnumExtensions;

enum ContactTypes: string
{
    use HasEnumExtensions;

    case Email = "email";
    case Phone = "phone";
}
