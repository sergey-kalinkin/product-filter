<?php


namespace App\Services\OffersFilter\Filter;


abstract class AFilterBuilder implements IFilterBuilder
{
    /**
     * @var IFilterOptionConstructor
     */
    protected $optionConstructor;

    /**
     * @var array
     */
    protected $data;
    /**
     * @var IFilterConstructor
     */
    protected $queryConstructor;

    //TODO notice - method with optional values looks like redundantly
    public function __construct(array $data = [], ?IFilterConstructor $filter_const = null)
    {
        $this->data = $data;

        $this->queryConstructor = $filter_const ?? new FilterConstructor();
        $this->optionConstructor = new FilterOptionConstructor(
            $this->queryConstructor
        );
    }

    public function getQueryOptionConstructor(): IFilterOptionConstructor
    {
        return $this->optionConstructor;
    }

    public function getQueryConstructor(): IFilterConstructor
    {
        return $this->queryConstructor;
    }
}
