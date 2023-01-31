<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeConditions;

/**
 * Wovosoft\BkbOffices\Models\Office
 *
 * @property int $id
 * @property string $name
 * @property string|null $bn_name
 * @property string|null $code
 * @property string|null $address
 * @property int|null $recommended_manpower
 * @property string|null $description
 * @property int|null $parent_id
 * @property int|null $office_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Wovosoft\BkbOffices\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Wovosoft\BkbOffices\Models\OfficeType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Office newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office query()
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereBnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereOfficeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereRecommendedManpower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office divisionalOffices(\Illuminate\Database\Eloquent\Builder $builder)
 * @mixin \Eloquent
 */
class Office extends BaseModel
{
    use HasFactory;
    use HasOfficeTypeConditions;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config("bkb-offices.table_prefix") . "offices";
    }

    protected $casts = [
        "type" => OfficeTypes::class
    ];

    /**
     * Returns the model of OfficeType by type key
     * @return BelongsTo
     */
    public function typeOf(): BelongsTo
    {
        return $this->belongsTo(OfficeType::class, "type", "type");
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function scopeOfType(Builder $builder, OfficeTypes|string $type): Builder
    {
        return $builder->where("type", '=', $type);
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }
}

