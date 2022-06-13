<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Models\Scopes\DivisionalAuditOffices;

class DivisionalAuditOffice extends Model
{
    use HasFactory;

    protected $table = "offices";

    protected static function booted()
    {
        static::addGlobalScope(new DivisionalAuditOffices());
    }

    public function regionalAuditOffices(): HasMany
    {
        return $this->hasMany(RegionalAuditOffice::class, "parent_id");
    }
}
