<?php

namespace Wovosoft\BkbOffices\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Wovosoft\BdGeocode\Models\District;
use Wovosoft\BkbOffices\Enums\OfficeTypes;
use Wovosoft\BkbOffices\Enums\ResidentAreas;

class StoreOfficeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Extend and update it according to needs.
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "name"                 => ["required", "string"],
            "bn_name"              => ["nullable", "string"],
            "ctr_branch_name"      => ["nullable", "string"],
            "code"                 => ["nullable", "string"],
            "sbs_code"             => ["nullable", "digits:4"],
            "phone"                => ["nullable", "string"],
            "email"                => ["nullable", "string"],
            "extended_code"        => ["nullable", "numeric", "max_digits:6", "min_digits:6"],
            "address"              => ["nullable", "string"],
            "recommended_manpower" => ["nullable", "numeric"],
            "current_manpower"     => ["nullable", "numeric"],
            "description"          => ["nullable", "string"],
            "district_id"          => [
                "nullable",
                Rule::exists(District::class, 'id')
            ],
            "parent_id"            => ["nullable", "numeric"],
            "type"                 => ["nullable", new Enum(OfficeTypes::class)],
            "resident_area"        => ["nullable", new Enum(ResidentAreas::class)],
        ];
    }
}
