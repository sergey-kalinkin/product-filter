<?php


namespace App\Services\OffersFilter\Filter\FilterBuilders;


use App\Services\OffersFilter\Filter\AFilterBuilder;
use Illuminate\Database\Eloquent\Builder;

class FilterRangeBuilder extends AFilterBuilder
{
    public function build() : Builder
    {
        $this->optionConstructor->addOnlyVisible()
                                ->addGroupSize($this->data)
                                ->addDurationRange($this->data)
                                ->addPrice($this->data);

        return $this->optionConstructor->getQuery();
    }
}
