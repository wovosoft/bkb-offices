# BKB Offices with GEO Locale Information

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This package is manly developed for the Laravel Related Applications of Bangladesh Krishi Bank.
Usually, in projects where Official Information is required, this package can be used.
It provides, full hierarchical list of different offices, office types etc. Below is the
detailed information.

## Features

- Office List
- Office Types
- Office Type wise Office List
- Datatable of Office/Office Types
- Basic CRUD Operations of Office/Office Types
- Options with query feature for Front-end applications, mostly for dropdowns.
- Automatic Routes for CRUD Operations of Office/Office Types
- Front-end Components in Blade/Vue/React/SVELTE
- GraphQL integration

## Installation

Via Composer

``` bash
composer require wovosoft/bkb-offices
```

## Usage

Check the  [detailed information here](docs/index.md)

N.B.: If routes are disabled by config file, then middleware list won't work.

Another methods of registering routes manually is:

```php
\Wovosoft\BkbOffices\BkbOffices::routes();
```

Now, if you want to group these routes, then just follow the below example.

```php
use \Illuminate\Support\Facades\Route;
use \Wovosoft\BkbOffices\BkbOffices;

Route::middleware(['auth','auth:sanctum'])->group(function (){
    BkbOffices::routes();
});
```

N.B.: When `BkbOffices::routes()` routes are used, the default methods provided
by traits `\Wovosoft\BkbOffices\Traits\` will be used.

## Controller actions/methods

This package provides CRUD methods for Controllers by traits.
You can use these traits by the example given below:

```php
namespace Wovosoft\BkbOffices\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Wovosoft\BkbOffices\Traits\HasOfficeCrud;

class OfficeController extends Controller
{
    use HasOfficeCrud;
}

```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author@email.com instead of using the issue tracker.

## Credits

- [Narayan Adhikary](https://github.com/wovosoft)
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/wovosoft/bkb-offices.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/wovosoft/bkb-offices.svg?style=flat-square

[ico-travis]: https://img.shields.io/travis/wovosoft/bkb-offices/master.svg?style=flat-square

[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/wovosoft/bkb-offices

[link-downloads]: https://packagist.org/packages/wovosoft/bkb-offices

[link-travis]: https://travis-ci.org/wovosoft/bkb-offices

[link-styleci]: https://styleci.io/repos/12345678

[link-author]: https://github.com/wovosoft

[link-contributors]: ../../contributors
