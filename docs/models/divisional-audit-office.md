# Wovosoft\BkbOffices\Models\DivisionalAuditOffice

| Title      | Description                                                                        |
|------------|------------------------------------------------------------------------------------|
| uses table | `offices`                                                                          |
| Purpose    | Distinguishes the Divisional Audit Offices from other Offices by office type `dao` |

This model has relationship with `RegionalAuditOffice` which is defined by `regionalAuditOffices` (hasMany)
methods.

## Get Regional Audit Offices

```php
$dao = \Wovosoft\BkbOffices\Models\DivisionalAuditOffice::first();
$dao->regionalAuditOffices; // returns regional audit offices of the DAO 
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
