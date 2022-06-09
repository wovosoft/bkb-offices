<?php

namespace Wovosoft\BkbOffices\Facades;

use Illuminate\Support\Facades\Facade;

class BkbOffices extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'bkb-offices';
    }
}
