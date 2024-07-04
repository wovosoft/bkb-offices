<?php

namespace Wovosoft\BkbOffices\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Wovosoft\BkbOffices\Enums\OfficeTypes;

/**
 * @property-read boolean $is_branch
 * @property-read boolean $is_corporate_branch
 * @property-read boolean $is_div_office
 * @property-read boolean $is_dao_office
 * @property-read boolean $is_rao_office
 * @property-read boolean $is_crm_rm_office
 * @property-read boolean $is_head _office
 */
trait HasOfficeTypeConditions
{
    public function isSubBranch(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::SubBranch);
    }

    public function isBranch(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::Branch);
    }

    public function isCorporateBranch(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::CorporateBranch);
    }

    public function isDivOffice(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::DivisionalOffice);
    }

    public function isDaoOffice(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::DivisionalAuditOffice);
    }

    public function isRaoOffice(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::RegionalAuditOffice);
    }

    public function isCrmRmOffice(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::CRM_RMOffice);
    }

    public function isHeadOffice(): Attribute
    {
        return Attribute::get(fn(): bool => $this->type === OfficeTypes::HeadOffice);
    }
}
