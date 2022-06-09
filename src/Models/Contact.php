<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wovosoft\BkbOffices\Enums\ContactTypes;

class Contact extends Model
{
    protected $casts = [
        "type" => ContactTypes::class
    ];
    use HasFactory;
}
