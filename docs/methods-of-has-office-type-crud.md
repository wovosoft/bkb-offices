### Methods of `Wovosoft\BkbOffices\Traits\HasOfficeTypeCrud::class`

### Create new Office Type

To Create new Office Type, following method should be used. It's recommended to submit form data in PUT method.
N.B.: When using PUT method, you should be aware of preflight requests. PUT/DELETE methods are not regular
HTTP form data submission methods.
Read [more about preflight requests](https://livebook.manning.com/book/cors-in-action/chapter-4/#:~:text=A%20preflight%20request%20is%20a,look%20like%20before%20it's%20made.)

This method automatically validates user submitted data.

```php
/**
* @Route : "offices/store" as PUT Method
* @param Request $request
* @return JsonResponse
* @throws \Throwable
*/
public function store(Request $request): JsonResponse
```

#### Usage in Controller

Just inject the trait `HasOfficeTypeCrud::class` as the example given below.

```php
class OfficeTypeController extends \App\Http\Controllers\Controller{
    use \Wovosoft\BkbOffices\Traits\HasOfficeTypeCrud;
}
```

#### Usage by Facades

```php
\Wovosoft\BkbOffices\Facades\BkbOffices::officeTypes()->store($request)
```

```php
/**
* @Route : "office_types/store" as PUT Method
* @param Request $request
* @return JsonResponse
* @throws \Throwable
*/
public function store(Request $request): JsonResponse
```

### Changing Validation Rules

1. In Controller, override following array

```php
 /**
 * Form Submit Validation Rules for store/update Operation
 * @var array|\string[][]
 */
private array $formValidations = [
    "name" => ["required", "string"],
    "bn_name" => ["nullable", "string"],
    "description" => ["nullable", "string"],
];
```

2. In Facade,

```php
 \Wovosoft\BkbOffices\Facades\BkbOffices::officeTypes()->setFormValidationRules([
    "name" => ["required", "string"],
    "bn_name" => ["nullable", "string"],
    "description" => ["nullable", "string"]
])
```

This method is used to generate datatables. To control the datatable provide following data along with form data

```js
axios.post('route/to/index', {
    'per_page': 15,
    'columns': ['*'],
    'page_name': 15,
    'page': 1
}).then(res => {
    console.log(res.data)
}).catch(err => {
    console.log(err?.response?.data)
});
```

```php
/**
* Data Pagination
* $request can contain pagination variables as
* ['per_page'=> int,'columns' => array,'page_name' => string,'page'=> int]
* @param Request $request
* @return LengthAwarePaginator
*/
public function index(Request $request): LengthAwarePaginator
```

This method is used to destroy an Office Record from database. Recommended method is DELETE.
N.B.: Delete method is a preflight method. This methods first auto resolves the Office Model,
then deletes it. This is because if it gets deleted by Office::destroy(id), then deleting, delete, deleted
etc. model events won't be triggered. So, it's always better to first resolve the model, then delete it.

```php
/**
* First the office is resolve, cause direct removal without
* resolving won't trigger delete related events.
* @Route : "offices/delete/{office}" as DELETE Method
* @param OfficeType $officeType
* @return JsonResponse
* @throws \Throwable
*/
public function destroy(OfficeType $officeType): JsonResponse
```

This method is used to retrieve list of records as dropdowns value.

```php
/**
* Provide options for dropdowns in front-end
* method : POST
* request params: filter => string, limit => int(25)
* @param Request $request
* @return Collection|array
*/
public function options(Request $request): Collection|array
```

### Changing column selection in options

1. When used in controller, override following variable

```php
 /**
     * Selectable Columns in options
     * @var array|string[]
     */
    private array $optionsSelectableCols = [
        "id", "name", "bn_name", "description"
    ];
```

2. When used by Facade

```php
\Wovosoft\BkbOffices\Facades\BkbOffices::officeTypes()->setOptionsSelectableCols([
        "id", "name", "bn_name", "description"
])->options(["filter"=>string])
```

## Changing options filter method

1. In Controller, override following method

```php
/**
* If needed to modify options, just modify this method.
* @param Builder $builder
* @param string $filter
* @return Builder
*/
 
private function optionsQuery(Builder $builder, string $filter): Builder
{
    $builder
        ->where("id", "=", $filter)
        ->orWhere("name", "LIKE", "%$filter%")
        ->orWhere("bn_name", "LIKE", "%$filter%");
    return $builder;
}
```

2. In Facade

   **Working on this.**

## Routes registration

If `config('bkb-offices.routes_enabled')` is set to `true`, then routes will be registered automatically.
But in case you need to register the routes manually follow the example given below:

1. Without applying further grouping, middleware etc.

```php
\Wovosoft\BkbOffices\Facades\BkbOffices::routes();
```

2. Applying further grouping, middleware etc.:

```php
\Illuminate\Support\Facades\Route::middleware(['auth:sanctum','auth:web'])
    ->prefix("wovosoft")
    ->controller(\Wovosoft\BkbOffices\Controllers\OfficeTypeController::class)
    ->group(function (){
        \Wovosoft\BkbOffices\Facades\BkbOffices::routes();
    }); 
```

N.B.: Traits can be injected in two ways

1. Extending Controllers provided by the package. Under the hood
   `\Wovosoft\BkbOffices\Controllers\OfficeTypeController:class` uses
   `\Wovosoft\BkbOffices\Traits\HasOfficeTypeCrud` trait.

```php
class ExtendedOfficeTypeController extends \Wovosoft\BkbOffices\Controllers\OfficeTypeController{

}
```

2. Using Traits

```php
class OfficeTypeController extends \App\Http\Controllers\Controller{
    use \Wovosoft\BkbOffices\Traits\HasOfficeTypeCrud;
}
```

## Something to be Noted

Generally, Office actions are provided by a singleton, but if you need a new instance, then pass `true` as
parameter.

```php
\Wovosoft\BkbOffices\Facades\BkbOffices::officeTypes(true);
```

## Offices of a certain Type

```php
/**
 * Returns Offices of a certain OfficeType
 * @param OfficeType $officeType
 * @param Request $request
 * @return Collection
 */
```

If You need to change the office query method, then override the method given below. Applicable for controller:

```php
/**
* If needed to modify options, just modify this method.
* @param Builder $builder
* @param string $filter
* @return Builder
*/
private function optionsQuery(Builder $builder, string $filter): Builder
{
    $builder
        ->where("id", "=", $filter)
        ->orWhere("name", "LIKE", "%$filter%")
        ->orWhere("bn_name", "LIKE", "%$filter%");
    return $builder;
}
```
