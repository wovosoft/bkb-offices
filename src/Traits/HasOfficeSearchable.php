<?php

namespace Wovosoft\BkbOffices\Traits;

use Laravel\Scout\Searchable;

trait HasOfficeSearchable
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bn_name' => $this->bn_name,
            'code' => $this->code,
        ];
    }
}
