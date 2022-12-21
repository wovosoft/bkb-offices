<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\RegionalAuditOffices;
use Wovosoft\BkbOffices\Traits\HasOfficeSearchable;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

class RegionalAuditOffice extends Model
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
        "type" => OfficeTypes::HeadOffice
    ];

    protected static function booted()
    {
        static::addGlobalScope(new RegionalAuditOffices());
    }

    public function divisionalAuditOffice(): BelongsTo
    {
        return $this->belongsTo(DivisionalAuditOffice::class, "parent_id");
    }
}
