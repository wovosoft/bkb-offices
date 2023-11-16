<?php

namespace Wovosoft\BkbOffices\Enums;

use Wovosoft\LaravelCommon\Traits\HasEnumExtensions;

/**
 * Sometimes, to quickly identify offices, we may need to use isBranch(), isDO, is DAO etc.
 * in that case enums can be a quick solution. But enums can't hold multiple attributes.
 * So, this enum's values will be used as alias of OfficeType model. The OfficeType model should
 * use these enum values.
 *
 * Using types as model has some other benefits. In ORM way, offices of certain types can be accessed.
 * Title and other descriptions can be modified easily without touching the source codes.
 *
 * In BKB, generally there are 7 types of Offices. In database same types should remain.
 */
enum OfficeTypes: string
{
    use HasEnumExtensions;

    case Branch                = "BR";
    case DivisionalOffice      = "DO";
    case DivisionalAuditOffice = "DAO";
    case RegionalAuditOffice   = "RAO";
    case CRM_RMOffice          = "RM/CRM";
    case CorporateBranch       = "CB";
    case HeadOffice            = "HO";
}
