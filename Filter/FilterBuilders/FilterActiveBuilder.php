<?php


namespace App\Services\OffersFilter\Filter\FilterBuilders;


use App\Services\OffersFilter\Filter\AFilterBuilder;
use Illuminate\Database\Eloquent\Builder;

class FilterActiveBuilder extends AFilterBuilder
{
    public function build() : Builder
    {
        $this->optionConstructor->addOnlyVisible();

        return $this->optionConstructor->getQuery();
    }
}
