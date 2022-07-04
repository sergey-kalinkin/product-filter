<?php


namespace App\Services\OffersFilter\Filter\FilterBuilders;


use App\Services\OffersFilter\Filter\AFilterBuilder;
use Illuminate\Database\Eloquent\Builder;

class FilterBaseKindBuilder extends AFilterBuilder
{
    public function build() : Builder
    {
        $this->optionConstructor->addOnlyVisible()
                                ->addRest($this->data);

        return $this->optionConstructor->getQuery();
    }
}
