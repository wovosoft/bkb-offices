<?php

namespace Wovosoft\BkbOffices;

use Wovosoft\BkbOffices\Actions\Offices;
use Wovosoft\BkbOffices\Actions\OfficeTypes;
use Illuminate\Support\Facades\Route;
use Wovosoft\BkbOffices\Controllers\OfficeController;
use Wovosoft\BkbOffices\Controllers\OfficeTypeController;

class BkbOffices
{
    /**
     * Returns instance of Wovosoft\BkbOffices\Actions\Offices::class which contains all CRUD methods
     * @param bool $newInstance
     * @return Offices
     */
    public function offices(bool $newInstance = false): Offices
    {
        if ($newInstance) {
            return new Offices();
        }
        return app("bkb-offices:offices");
    }

    /**
     * Returns instance of Wovosoft\BkbOffices\Actions\OfficeTypes::class which contains all CRUD methods
     * @param bool $newInstance
     * @return OfficeTypes
     */
    public function officeTypes(bool $newInstance = false): OfficeTypes
    {
        if ($newInstance) {
            return new OfficeTypes();
        }
        return app("bkb-offices:office_types");
    }

    /*
     * Registers default CRUD Routes
     * These routes are wrapped by the default middlewares defined in config('bkb-offices.routes_middleware')
     * @return void
     */
    public static function routes(): void
    {
        Route::controller(OfficeController::class)
            ->prefix("offices")
            ->name("offices.")
            ->group(function () {
                Route::put("store", "store")->name("store");
                Route::put("update/{office}", "update")->name("update");
                Route::post("/", "index")->name("index");
                Route::delete("/delete/{office}", "delete")->name("delete");
                Route::post("/options", "options")->name("options");
            });

        Route::controller(OfficeTypeController::class)
            ->prefix("office_types")
            ->name("office_types.")
            ->group(function () {
                Route::put("store", "store")->name("store");
                Route::put("update/{office}", "update")->name("update");
                Route::post("/", "index")->name("index");
                Route::delete("/delete/{office}", "delete")->name("delete");
                Route::post("/options", "options")->name("options");
                Route::post("/type/{office_type}/offices", "offices")->name("offices");
            });
    }
}
