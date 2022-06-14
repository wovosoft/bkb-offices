<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\DivisionalOffices;
use Wovosoft\BkbOffices\Traits\HasOfficeSearchable;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

class DivisionalOffice extends Model
{
    use HasOfficeTypeConditions;
    use HasOfficeSearchable;

    protected $table = "offices";
    protected $casts = [
        "type" => OfficeTypes::class
    ];

    //https://stackoverflow.com/questions/39912372/how-to-set-the-default-value-of-an-attribute-on-a-laravel-model
    protected $attributes = [
        "type" => OfficeTypes::DivisionalOffice
    ];


    public static function booted()
    {
        static::addGlobalScope(new DivisionalOffices);
    }

    public function crmRmOffices(): HasMany
    {
        return $this->hasMany(CrmRmOffice::class, "parent_id", "id");
    }
}
