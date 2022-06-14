# `Wovosoft\BkbOffice\Models\OfficeType`

| Title      | Description                                                                                                                    |
|------------|--------------------------------------------------------------------------------------------------------------------------------|
| uses table | `office_types`                                                                                                                 |
| Purpose    | This table is used to hold the records of office types                                                                         |

## A short discussion

There are seven types of offices of Bangladesh Krishi Bank. These are listed below:

1. Divisional Offices (GM/DO) => `do`
2. Chief Regional / Regional Office (CRM/RM) => `crm_rm`
3. Branches => `br`
4. Divisional Audit Offices => `dao`
5. Regional Audit Offices => `rao`
6. Corporate Branches => `cb`
7. Departments of Head Office => `ho`

## Why do we need this model?

The answer of this question is good to know. Because, when we are using enum `Wovosoft\BkbOffices\Enums\OfficeTypes`
then why do we need a model for same types?

The answer, is The records of OfficeType model has same identical `type` values of the
enum `Wovosoft\BkbOffices\Enums\OfficeTypes`. In all other cases whenever we need office type the enum should be used.
But when we want offices of a certain type in ORM style we will use The OfficeType model.

```php
use \Wovosoft\BkbOffices\Models\OfficeType;
use \Wovosoft\BkbOffices\Enums\OfficeTypes;

$ot=OfficeType::whereType(OfficeTypes::RegionalAuditOffice)->first();
$ot->offices->toArray();
```

Also, using a separate table can let us holds extra info for a type, which is not possible by enums.

## Checking type

There are custom attributes to check the type of Office Type

1. `is_branch`
2. `is_corporate_branch`
3. `is_div_office`
4. `is_dao_office`
5. `is_rao_office`
6. `is_crm_rm_office`
7. `is_head_office` 
