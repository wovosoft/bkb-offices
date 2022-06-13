<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\Branches;

class Branch extends Model
{
    use HasFactory;

    protected $table = "offices";
    protected $casts = [
        "type" => OfficeTypes::class
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
