<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Models\Scopes\DivisionalOffices;

class DivisionalOffice extends Model
{
    use HasFactory;

    protected $table = "offices";

    public static function booted()
    {
        static::addGlobalScope(new DivisionalOffices);
    }

    public function crmRmOffices(): HasMany
    {
        return $this->hasMany(CrmRmOffice::class, "parent_id", "id");
    }
}
