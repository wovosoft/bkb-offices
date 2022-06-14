# Getting Started

## Installation

Via Composer

```shell
composer require wovosoft/bkb-offices
```

## Requirements

The package should have minimum support for

- Laravel 9
- php >= 8.1
- MySQL 5

## Creating Tables

The package provides default migration files for required tables to be created. So, you can just run:

```shell
php artisan migrate
```

## Import Office & Other Records

The package includes backup of all the offices of BKB and other necessary information in `./assets` folder.
Now, run following command to seed these records.

```shell
php artisan bkb-offices:import
```

After successful run, the above command will show You success messages.
