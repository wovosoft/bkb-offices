<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\CrmRmOffices;
use Wovosoft\BkbOffices\Traits\HasOfficeSearchable;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

class CrmRmOffice extends Model
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
        "type" => OfficeTypes::CRM_RMOffice
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CrmRmOffices());
    }

    public function divisionalOffice(): BelongsTo
    {
        return $this->belongsTo(DivisionalOffice::class, 'parent_id');
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class, "parent_id");
    }
}
