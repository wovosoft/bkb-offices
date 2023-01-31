<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\DivisionalAuditOffices;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

class DivisionalAuditOffice extends BaseModel
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
        "type" => OfficeTypes::DivisionalAuditOffice
    ];

    protected static function booted()
    {
        static::addGlobalScope(new DivisionalAuditOffices());
    }

    public function regionalAuditOffices(): HasMany
    {
        return $this->hasMany(RegionalAuditOffice::class, "parent_id");
    }
}
