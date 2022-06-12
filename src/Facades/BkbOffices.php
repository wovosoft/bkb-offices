<?php

namespace Wovosoft\BkbOffices\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method \Wovosoft\BkbOffices\BkbOffices offices
 * @method \Wovosoft\BkbOffices\BkbOffices officeTypes
 * @method void routes
 */
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
