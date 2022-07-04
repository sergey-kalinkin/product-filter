<?php


namespace App\Services\OffersFilter\FilterData\FilterBodyBuilders;


use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;

class FilterCategoryBodyBuilder extends AFilterBodyBuilder
{
    public function build(): array
    {
        $this->constructor->addSeason()
                            ->addRegion()
                            ->addAgeRestriction()
                            ->addRest()
                            ->addAllocation()
                            ->addComplexity()
                            ->addCollection()
                            ->addDurationType();

        return $this->constructor->getData();
    }
}
