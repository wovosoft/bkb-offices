<?php

namespace Wovosoft\BkbOffices\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Wovosoft\BkbOffices\Enums\OfficeTypes;

class SubBranches implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where("type", "=", OfficeTypes::SubBranch);
    }

}
