<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\CrmRmOffices;

class CrmRmOffice extends Model
{
    use HasFactory;

    protected $table = "offices";
    protected $casts = [
        "type" => OfficeTypes::class
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
