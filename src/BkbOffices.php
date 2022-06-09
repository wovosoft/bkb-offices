<?php

namespace Wovosoft\BkbOffices;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Wovosoft\BkbOffices\Models\Office;
use Wovosoft\BkbOffices\Models\OfficeType;
use Illuminate\Support\Facades\Route;
use Wovosoft\BkbOffices\Controllers\OfficeController;
use Wovosoft\BkbOffices\Controllers\OfficeTypeController;

class BkbOffices
{
    /**
     * Returns Full Office List
     * @param array $cols
     * @param array $with
     * @param array $appends
     * @return Collection|array
     */
    public function list(array $cols = ['*'], array $with = [], array $appends = []): Collection|array
    {
        return Office::query()
            ->select($cols)
            ->with($with)
            ->get()
            ->append($appends);
    }

    private function optionsQuery(Builder $builder, string $filter): void
    {
        $builder
            ->where("id", "=", $filter)
            ->orWhere("name", "LIKE", "%$filter%")
            ->orWhere("bn_name", "LIKE", "%$filter%")
            ->orWhere("code", "LIKE", "%$filter%")
            ->orWhere("address", "LIKE", "%$filter%");
    }

    private function optionTypesQuery(Builder $builder, string $filter): void
    {
        $builder
            ->where("id", "=", $filter)
            ->orWhere("name", "LIKE", "%$filter%")
            ->orWhere("bn_name", "LIKE", "%$filter%")
            ->orWhere("code", "LIKE", "%$filter%")
            ->orWhere("address", "LIKE", "%$filter%");
    }

    public function options(
        ?string $filter = null,
        array   $cols = ['*'],
        array   $with = [],
        array   $appends = [],
        Closure $filterCallback = null): Collection|array
    {
        return Office::query()
            ->when($filter, function (Builder $builder, string $filter) use ($filterCallback) {
                if ($filterCallback) {
                    $filterCallback($builder, $filter);
                } else {
                    $this->optionsQuery($builder, $filter);
                }
            })
            ->select($cols)
            ->with($with)
            ->get()
            ->append($appends);
    }

    public function types(array $cols = ['*'], array $with = [], array $appends = []): Collection|array
    {
        return OfficeType::query()
            ->select($cols)
            ->with($with)
            ->get()
            ->append($appends);
    }

    public function typeOptions(
        ?string $filter = null,
        array   $cols = ['*'],
        array   $with = [],
        array   $appends = [],
        Closure $filterCallback = null): Collection|array
    {
        return OfficeType::query()
            ->when($filter, function (Builder $builder, string $filter) use ($filterCallback) {
                if ($filterCallback) {
                    $filterCallback($builder, $filter);
                } else {
                    $this->optionTypesQuery($builder, $filter);
                }
            })
            ->select($cols)
            ->with($with)
            ->get()
            ->append($appends);
    }

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
            ->prefix("offices")
            ->name("offices.")
            ->group(function () {
                Route::put("store", "store")->name("store");
                Route::put("update/{office}", "update")->name("update");
                Route::post("/", "index")->name("index");
                Route::delete("/delete/{office}", "delete")->name("delete");
                Route::post("/options", "options")->name("options");
            });
    }
}
