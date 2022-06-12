<?php

namespace Wovosoft\BkbOffices\Actions;

use Wovosoft\BkbOffices\Traits\HasOfficeCrud;

class Offices
{
    use HasOfficeCrud;

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
     * Now, rest of the CRUD methods are available. Those can be used like used in controllers
     * method optionsQuery of HasOfficeCrud can be overwritten
     */
}
