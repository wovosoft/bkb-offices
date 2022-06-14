<?php

namespace Wovosoft\BkbOffices\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Wovosoft\BkbOffices\Enums\OfficeTypes;

trait HasOfficeTypeConditions
{
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
