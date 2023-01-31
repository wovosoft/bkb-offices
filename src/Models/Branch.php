<?php

namespace Wovosoft\BkbOffices\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\Branches;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

class Branch extends BaseModel
{
    use HasOfficeTypeConditions;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config("bkb-offices.table_prefix") . "offices";
    }

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
