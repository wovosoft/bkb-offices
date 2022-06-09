<?php

use Illuminate\Support\Facades\Route;
use Wovosoft\BkbOffices\BkbOffices;

/**
 * Note: Whether routes are enabled or not, is checked in Service Provider.
 *
 */
Route::middleware(config("bkb-offices.routes_middleware"))
    ->group(function () {
        BkbOffices::routes();
    });
