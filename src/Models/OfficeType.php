<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

/**
 * Wovosoft\BkbOffices\Models\OfficeType
 *
 * @property int $id
 * @property string $name
 * @property string|null $bn_name
 * @property string|null $description
 * @property OfficeTypes $type Type of Wovosoft\BkbOffices\Enums\OfficeTypes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Wovosoft\BkbOffices\Models\Office[] $offices
 * @property-read int|null $offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType whereBnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OfficeType extends Model
{
    use HasFactory;
    use HasOfficeTypeConditions;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config("bkb-offices.table_prefix") . "office_types";
    }

    protected $casts = [
        "type" => OfficeTypes::class
    ];

    public function toSearchableArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "bn_name" => $this->bn_name
        ];
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class, "type", "type");
    }
}
