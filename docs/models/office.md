# `Wovosoft\BkbOffice\Models\Office`

| Title      | Description                                                                                                                     |
|------------|---------------------------------------------------------------------------------------------------------------------------------|
| uses table | `offices`                                                                                                                       |
| Purpose    | This table is used to hold the records of all type of offices. Eg. Divisional Offices, CRM/RM Offices, Branches etc.            |  
| Types      | Different type of Offices are differentiated by `type` field which is alias of the enum `Wovosoft\BkbOffices\Enums\OfficeTypes` |

## A short discussion

There are seven types of offices of Bangladesh Krishi Bank. These are listed below:

1. Divisional Offices (GM/DO)
2. Chief Regional / Regional Office (CRM/RM)
3. Branches
4. Divisional Audit Offices
5. Regional Audit Offices
6. Corporate Branches
7. Departments of Head Office

All these offices are separated by their `type` attribute. The `type` attribute holds only the values of the enum
`Wovosoft\BkbOffices\Enums\OfficeTypes`. If values other than this enum is provided, then the value won't be acceptable.
Using this `field` offices are differentiated.

Now, there is another important field `parent_id`. This field is responsible for the hierarchy relationship among the
Offices. Let's make it clearer: Branches goes under CRM/RM Offices, CRM/RM Offices goes under Divisional Offices.
So, a Branch holds the `id` of its CRM/RM Office as it's `parent_id` and a CRM/RM Office holds the `id` of its
Divisional Office as it's `parent_id`.

That means the `hasMany`, `belongsTo`, `hasOne` etc. relationships among the offices references to the same model. And
that is done by the defined relationships `parent` and `children`. In most cases this is fine, but it creates a little
semantic issue. The `parent` and `children` names are not semantically suited for offices. We need a better solution.
This issue is solved by the `pseudo` models listed below:

1. [Wovosoft\BkbOffices\Models\DivisionalOffice](/models/divisional-office)
2. [Wovosoft\BkbOffices\Models\CrmRmOffice](/models/crm-rm-office)
3. [Wovosoft\BkbOffices\Models\Branch](/models/branch)
4. [Wovosoft\BkbOffices\Models\CorporateBranch](/models/corporate-branch)
5. [Wovosoft\BkbOffices\Models\DivisionalAuditOffice](/models/divisional-audit-office)
6. [Wovosoft\BkbOffices\Models\RegionalAuditOffice](/models/regional-audit-office)
7. [Wovosoft\BkbOffices\Models\HeadOffice](/models/head-office)

## Why pseudo models

We already have offices in Wovosoft\BkbOffices\Models\Office model. So, don't need to apply same thing again in
different models. The above pseudo models just let us help to find the offices in a better semantic way.

## Implementation of pseudo models

First, we have created global scopes for the seven types of offices. These are listed below:

1. [Wovosoft\BkbOffices\Models\Scopes\DivisionalOffices](https://github.com/wovosoft/bkb-offices/blob/master/src/Models/Scopes/Branches.php)
2. [Wovosoft\BkbOffices\Models\Scopes\CrmRmOffices](https://github.com/wovosoft/bkb-offices/blob/master/src/Models/Scopes/CrmRmOffices.php)
3. [Wovosoft\BkbOffices\Models\Scopes\Branches](https://github.com/wovosoft/bkb-offices/blob/master/src/Models/Scopes/Branches.php)
4. [Wovosoft\BkbOffices\Models\Scopes\CorporateBranches](https://github.com/wovosoft/bkb-offices/blob/master/src/Models/Scopes/CorporateBranches.php)
5. [Wovosoft\BkbOffices\Models\Scopes\DivisionalAuditOffices](https://github.com/wovosoft/bkb-offices/blob/master/src/Models/Scopes/DivisionalAuditOffices.php)
6. [Wovosoft\BkbOffices\Models\Scopes\RegionalAuditOffices](https://github.com/wovosoft/bkb-offices/blob/master/src/Models/Scopes/RegionalAuditOffices.php)
7. [Wovosoft\BkbOffices\Models\Scopes\HeadOffices](https://github.com/wovosoft/bkb-offices/blob/master/src/Models/Scopes/HeadOffices.php)

Then each pseudo model uses its corresponding global scope to make the different from others.

Example of Branch Scope

```php
<?php

namespace Wovosoft\BkbOffices\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Wovosoft\BkbOffices\Enums\OfficeTypes;

class Branches implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where("type", "=", OfficeTypes::Branch);
    }

}
```

Example of Branches scope application in Branch pseodo model

```php
<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Models\Scopes\Branches;

class Branch extends Model
{
    protected $table = "offices";
    protected static function booted()
    {
        static::addGlobalScope(new Branches);
    }
}
```

Same logic has been applied for the other pseudo models. These pseudo models contains the relationships among different
types of offices. Check the source code for [more details](#implementation-of-pseudo-models).

## Checking type

There are custom attributes to check the type of Office Type

1. `is_branch`
2. `is_corporate_branch`
3. `is_div_office`
4. `is_dao_office`
5. `is_rao_office`
6. `is_crm_rm_office`
7. `is_head_office` 
