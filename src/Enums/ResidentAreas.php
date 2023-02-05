<?php

namespace Wovosoft\BkbOffices\Enums;

use Wovosoft\LaravelCommon\Traits\HasEnumExtensions;

enum ResidentAreas: string
{
    use HasEnumExtensions;

    //Dhaka City Corporation area
    case Dhaka = "dhaka";

    case Other_Dhaka = "other_dhaka";
    case Others = "others";
}
