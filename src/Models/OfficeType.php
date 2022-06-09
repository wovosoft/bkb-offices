<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Enums\OfficeTypes;

class OfficeType extends Model
{
    use HasFactory;

    protected $casts = [
        "type" => OfficeTypes::class
    ];

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    public function isBranch(): Attribute
    {
        return Attribute::get(fn() => $this->type === OfficeTypes::Branch);
    }

    public function isCorporateBranch(): Attribute
    {
        return Attribute::get(fn() => $this->type === OfficeTypes::CorporateBranch);
    }

    public function isDivOffice(): Attribute
    {
        return Attribute::get(fn() => $this->type === OfficeTypes::DivisionalOffice);
    }

    public function isDaoOffice(): Attribute
    {
        return Attribute::get(fn() => $this->type === OfficeTypes::DivisionalAuditOffice);
    }

    public function isRaoOffice(): Attribute
    {
        return Attribute::get(fn() => $this->type === OfficeTypes::RegionalAuditOffice);
    }

    public function isCrmRmOffice(): Attribute
    {
        return Attribute::get(fn() => $this->type === OfficeTypes::CRM_RMOffice);
    }

    public function isHeadOffice(): Attribute
    {
        return Attribute::get(fn() => $this->type === OfficeTypes::HeadOffice);
    }

}
