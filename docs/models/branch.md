# Wovosoft\BkbOffices\Models\Branch

| Title      | Description                                                       |
|------------|-------------------------------------------------------------------|
| uses table | `offices`                                                         |
| Purpose    | Distinguishes the Branches from other Offices by office type `br` |

## Get CRM/RM office related to the Branch

The `Branch` model has `BelongsTo` relationship defined by `crmRmOffice` method with `CrmRmOffice` model. So, just by
using the `crmRmOffice` prop to get the associated `CrmRmOffice`

```php
$branch = \Wovosoft\BkbOffices\Models\Branch::first();
$branch->crmRmOffice->toJson(JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
```

This will give you the following output

```json
{
    "id": 2,
    "name": "Chief Regional Office, Gazipur",
    "bn_name": "মুখ্য আঞ্চলিক কার্যালয়, গাজীপুর",
    "code": "",
    "address": "Bangladesh Krishi Bank, Chief Regional Office, Dist:  Gazipur, Thana:",
    "recommended_manpower": 0,
    "description": null,
    "parent_id": 1,
    "type": "crm_rm",
    "created_at": "2022-06-13T12:07:10.000000Z",
    "updated_at": "2022-06-13T12:07:10.000000Z"
}
```

## Automatic Branch Type

Whenever you are creating or updating a Branch, the Branch type will be set automatically. Check the examples given
below:

```php
$branch = new \Wovosoft\BkbOffices\Models\Branch();
var_dump($branch->toArray());
```

The above will create something like the array given below:

```php
array(1) {
  ["type"]=> string(2) "br"
}
```

Which means office type is set automatically. Same thing happens when updating a Branch. But in that case you shouldn't
define value for the type.

## Checking type

There are custom attributes to check the type of Office Type

1. `is_branch`
2. `is_corporate_branch`
3. `is_div_office`
4. `is_dao_office`
5. `is_rao_office`
6. `is_crm_rm_office`
7. `is_head_office` 
