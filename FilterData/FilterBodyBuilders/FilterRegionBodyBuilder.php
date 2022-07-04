<?php


namespace App\Services\OffersFilter\FilterData\FilterBodyBuilders;


use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;

class FilterRegionBodyBuilder extends AFilterBodyBuilder
{
    public function build(): array
    {
        $this->constructor->addSeason()
                            ->addAgeRestriction()
                            ->addRest()
                            ->addAllocation()
                            ->addComplexity()
                            ->addCollection()
                            ->addCategory()
                            ->addDurationType();

        return $this->constructor->getData();
    }
}
