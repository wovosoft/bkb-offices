<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Model;
use Wovosoft\LaravelCommon\Traits\HasTablePrefix;

class BaseModel extends Model
{
    use HasTablePrefix;

    public function __construct(array $attributes = [])
    {
        $this->connection = config("bkb-offices.database_connection");
        parent::__construct($attributes);
    }

    public function getPrefix(): string
    {
        return config("bkb-offices.table_prefix");
    }
}
