<?php


namespace App\Services\OffersFilter\FilterData;


use Illuminate\Database\Eloquent\Builder;

abstract class AFilterBodyBuilder implements IFilterBodyBuilder
{
    protected $constructor;

    public function __construct(?Builder $builder = null)
    {
        $this->constructor = new FilterBodyConstructor($builder);
    }
}
