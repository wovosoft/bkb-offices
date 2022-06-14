<?php

namespace Wovosoft\BkbOffices\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\Branches;
use Wovosoft\BkbOffices\Traits\HasOfficeSearchable;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

class Branch extends Model
{
    use HasOfficeTypeConditions;
    use HasOfficeSearchable;

    protected $table = "offices";
    protected $casts = [
        "type" => OfficeTypes::class
    ];

    //https://stackoverflow.com/questions/39912372/how-to-set-the-default-value-of-an-attribute-on-a-laravel-model
    protected $attributes = [
        "type" => OfficeTypes::Branch
    ];

    protected static function booted()
    {
        static::addGlobalScope(new Branches);
    }


    public function crmRmOffice(): BelongsTo
    {
        return $this->belongsTo(CrmRmOffice::class, "parent_id", "id");
    }
}
