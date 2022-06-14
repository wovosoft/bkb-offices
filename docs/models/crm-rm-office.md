# Wovosoft\BkbOffices\Models\CrmRmOffice

| Title      | Description                                                                 |
|------------|-----------------------------------------------------------------------------|
| uses table | `offices`                                                                   |
| Purpose    | Distinguishes the CRM/Rm Offices from other Offices by office type `crm-rm` |

This model has relationship with `Branch` and `DivisionalOffice` which are defined by `branches` (hasMany)
and `divisionalOffice` (belongsTo)
methods.

## Get Branches of a CRM/RM Office

```php
$crmRmOffice = \Wovosoft\BkbOffices\Models\CrmRmOffice::first();
$crmRmOffice->branches; // returns branches of this crm/rm office 
```

## Get Divisional Office of a CRM/RM Office

```php
$crmRmOffice = \Wovosoft\BkbOffices\Models\CrmRmOffice::first();
$crmRmOffice->divisionalOffice; //returns Divisional Office
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
