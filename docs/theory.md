# Theory behind the package

## Actions in Traits

All CRUD Operations for `Offices` and `Office Types` are seperated in two traits, so that these actions can be reused
in Controllers, Containers & Service Providers. The available Traits, which provide actions are listed below:

- `Wovosoft\BkbPackages\Traits\HasOfficeCrud`
    - `store`   : Method to create new Office Record
    - `update`  : Method to update existing Office Record
    - `index`   : Method to paginate Office Records with Datatable feature
    - `destroy` : Method to destroy an existing Office Record
    - `options` : Method to provide data as options to be used in frontend dropdowns/list.
- `Wovosoft\BkbPackages\Traits\HasOfficeTypeCrud`
    - `store`   : Method to create new Office Type Record
    - `update`  : Method to update existing Office Type Record
    - `index`   : Method to paginate Office Type Records with Datatable feature
    - `destroy` : Method to destroy an existing Office Type Record
    - `options` : Method to provide data as options to be used in frontend dropdowns/list.
    - `offices` : Method to provide list of offices of a certain OfficeType.

## Usage of Actions

### 1. In Controllers

Now, to make these actions available in Controllers, need to inject these traits as like any other trait in Controller
classes.

```php
use \App\Http\Controllers\Controller;
use \Wovosoft\BkbOffices\Traits\HasOfficeCrud;

class OfficeController extends Controller{
    use HasOfficeCrud;  // NOTE this line
}
```

```php
use \App\Http\Controllers\Controller;
use \Wovosoft\BkbOffices\Traits\HasOfficeTypeCrud;

class OfficeTypeController extends Controller{
    use HasOfficeTypeCrud;  // NOTE this line
}
```

Now, `OfficeController` has all the methods of `HasOfficeCrud` trait and `OfficeTypeController` has all the methods of
`HasOfficeTypeCrud` trait.

In any case, you need to modify the behavior of the default methods, just override those methods.

### 2. In Container

The actions provided by the above two describing traits, are also available in `Wovosoft\BkbOffices\BkbOffices` class.
This class can be constructed when need to have the CRUD options for offices and types.

To make the above task simple and quicker, `Wovosoft\BkbOffices\Facades\BkbOffices` facade class provides a singleton
of `Wovosoft\BkbOffices\BkbOffices`. In most cases you should use `Wovosoft\BkbOffices\Facades\BkbOffices` facade class.

`Wovosoft\BkbOffices\Facades\BkbOffices` facade provides two methods offices & officeTypes to have the methods
of `HasOfficeCrud` trait and `HasOfficeTypeCrud` respectively.

```php
use Wovosoft\BkbOffices\Facades\BkbOffices;

BkbOffices::offices()->store($request);
BkbOffices::offices()->index($request);
BkbOffices::offices()->destroy(1);

BkbOffices::officeTypes()->store($request);
BkbOffices::officeTypes()->index($request);
BkbOffices::officeTypes()->destroy(1);
```

The above example is applicable when you have customized version of Office & OfficeType Controllers.

## Default Controllers

To, register routes automatically, the package needs Controllers. So, the package have two default Controllers.

```php
Wovosoft\BkbOffices\Controllers\OfficeController::class;
Wovosoft\BkbOffices\Controllers\OfficeTypeController::class;
```

Now, you can extend these classes or use Traits to have the CRUD actions in your controllers. Choice is yours.
But to me, using traits is much better.

## Models of Two Types

The package uses only one table for all type of offices and another table for office types.
Office Types are enum values. But, we know that php's enums are key=>value paired. We can't hold extra information or
have ORM feature with enums. We need models in that case. So, OfficeType model is created for office types.

So, type # 1 of model is :

- `Wovosoft\BkbOffices\Models\OfficeType`
- `Wovosoft\BkbOffices\Models\Office`

...and to easily categorized different types of Offices the package has the following models:

- `Wovosoft\BkbOffices\Models\DivisionalOffice`
- `Wovosoft\BkbOffices\Models\CrmRmOffice`
- `Wovosoft\BkbOffices\Models\Branch`
- `Wovosoft\BkbOffices\Models\CorporateBranch`
- `Wovosoft\BkbOffices\Models\DivisionalAuditOffice`
- `Wovosoft\BkbOffices\Models\RegionalAuditOffice`
- `Wovosoft\BkbOffices\Models\HeadOffice`

Note, the above models of type # 2, are fake models. These models use same table of  
`Wovosoft\BkbOffices\Models\Office`.
The models of type # 2 really helps to have all the features of ORM.

## Relations among different models

1. `DivisionalOffice` `hasMany(CrmRmOffice)` : `crmRmOffices`
    1. `CrmRmOffice` `hasMany(Branch)` : `branches`
2. `DivisionalAuditOffice` `hasMany(RegionalAuditOffice)` : `regionalAuditOffices`
3. `HeadOffice`

The above relations has vice-versa relationship defined.

These above relations among different models, helps to easily offices in tree structure.
