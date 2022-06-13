<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\RegionalAuditOffices;

class RegionalAuditOffice extends Model
{
    use HasFactory;

    protected $table = "offices";
    protected $casts = [
        "type" => OfficeTypes::class
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
