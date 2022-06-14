# Office Types

Office Types are fixed in quantity and definition. There are 7 types of offices till now.

- Branch = "br";
- Divisional Office = "do";
- Divisional Audit Office = "dao";
- Regional Audit Office = "rao";
- Chief Regional Office / Regional Office = "crm_rm";
- Corporate Branch = "cb";
- Head Office = "ho";

The right side texts after "=" denotes the unique key for each type of respective offices. These keys should be used all
over the projects for different type of offices.

## Office denoting keys in php enums

As of the version of `php >=8.1` we have support for enums in php. According to the above discussion, it's better to
wrap
the office types in enums. So, the package have `Wovosoft\BkbOffices\Enums\OfficeTypes` enums.

N.B.: The enum `Wovosoft\BkbOffices\Enums\OfficeTypes` has been cast to the related models, so that you can use Laravel
9's enum casting feature. See the example give below to have clear understanding:

```php
use \Wovosoft\BkbOffices\Enums\OfficeTypes;

if ($model->type === OfficeTypes::DivisionalOffice){
    return "Divisional Office";
}
```

Without type casting of enums in Laravel you will have to do the same task as given below:

```php
use \Wovosoft\BkbOffices\Enums\OfficeTypes;

if ($model->type === OfficeTypes::DivisionalOffice->value){
    return "Divisional Office";
}
```

Both Office and OfficeTypes have `type` field, which creates link between two Models.
Relations are established with `type` field and not by `id` or `office_type_id`.

**Final Note:** There should have only 7 records of Office Types in `office_types` table with seven different `types`.

