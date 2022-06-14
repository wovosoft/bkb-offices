<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Model;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\HeadOffices;
use Wovosoft\BkbOffices\Traits\HasOfficeSearchable;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

class HeadOffice extends Model
{
    use HasOfficeTypeConditions;
    use HasOfficeSearchable;

    protected $table = "offices";
    protected $casts = [
        "type" => OfficeTypes::class
    ];

    //https://stackoverflow.com/questions/39912372/how-to-set-the-default-value-of-an-attribute-on-a-laravel-model
    protected $attributes = [
        "type" => OfficeTypes::HeadOffice
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HeadOffices());
    }
}
