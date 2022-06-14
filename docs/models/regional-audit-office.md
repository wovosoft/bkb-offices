# Wovosoft\BkbOffices\Models\RegionalAuditOffice

| Title      | Description                                                                      |
|------------|----------------------------------------------------------------------------------|
| uses table | `offices`                                                                        |
| Purpose    | Distinguishes the Regional Audit Offices from other Offices by office type `rao` |

This model has relationship with `DivisionalAuditOffice` which is defined by `divisionalAuditOffice` (belongsTo)
methods.

## Get Divisional Audit Office

```php
$rao = \Wovosoft\BkbOffices\Models\RegionalAuditOffice::first();
$rao->divisionalAuditOffice; // returns divisional audit office of the RAO 
```


N.B.: `type` is automatically initiated when creating/updating new CrmRmOffice instance.

## Checking type

There are custom attributes to check the type of Office Type

1. `is_branch`
2. `is_corporate_branch`
3. `is_div_office`
4. `is_dao_office`
5. `is_rao_office`
6. `is_crm_rm_office`
7. `is_head_office` 
