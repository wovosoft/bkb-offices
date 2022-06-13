<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\HeadOffices;

class HeadOffice extends Model
{
    use HasFactory;

    protected $table = "offices";
    protected $casts = [
        "type" => OfficeTypes::class
    ];
    protected static function booted()
    {
        static::addGlobalScope(new HeadOffices());
    }
}
