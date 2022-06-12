<?php

namespace Wovosoft\BkbOffices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @mixin \Eloquent
 */
class Office extends Model
{
    use HasFactory;

    public function type(): BelongsTo
    {
        return $this->belongsTo(OfficeType::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
