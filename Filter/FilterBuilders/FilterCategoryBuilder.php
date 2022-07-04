<?php


namespace App\Services\OffersFilter\Filter\FilterBuilders;


use App\Services\OffersFilter\Filter\AFilterBuilder;
use Illuminate\Database\Eloquent\Builder;

class FilterCategoryBuilder extends AFilterBuilder
{
    public function build() : Builder
    {
        $this->optionConstructor->addOnlyVisible()
                                ->addCategory($this->data)
                                ->addCollection($this->data)
                                ->addAllocation($this->data)
                                ->addComplexity($this->data)
                                ->addRest($this->data)
                                ->addAgeRestriction($this->data)
                                ->addRegion($this->data)
                                ->addSeason($this->data)
                                ->addDurationType($this->data);

        return $this->optionConstructor->getQuery();
    }
}
