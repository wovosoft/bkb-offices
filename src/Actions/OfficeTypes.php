<?php

namespace Wovosoft\BkbOffices\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Wovosoft\BkbOffices\Models\OfficeType;
use Wovosoft\BkbOffices\Traits\HasOfficeTypeCrud;

class OfficeTypes
{
    use HasOfficeTypeCrud;

    /**
     * Sets default column selection for options
     * @param array $cols
     * @return $this
     */
    public function setOptionsSelectableCols(array $cols): static
    {
        $this->optionsSelectableCols = $cols;
        return $this;
    }

    /**
     * Sets default form data validation rules for store/update method
     * @param array $rules
     * @return $this
     */
    public function setFormValidationRules(array $rules): static
    {
        $this->formValidations = $rules;
        return $this;
    }

    /**
     * Returns the Builder/List of OfficeTypes
     * @param bool $getBuilder
     * @return Collection|array|Builder|OfficeType
     */
    public function list(bool $getBuilder = false): Collection|array|Builder|OfficeType
    {
        $builder = OfficeType::query();
        if (!$getBuilder) {
            return $builder->get();
        }
        return $builder;
    }
}
