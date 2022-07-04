<?php


namespace App\Services\OffersFilter\FilterData\FilterBodyBuilders;


use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;

class FilterKindBodyBuilder extends AFilterBodyBuilder
{
    public function build(): array
    {
        $this->constructor->addSeason()
                            ->addAgeRestriction()
                            ->addAllocation()
                            ->addComplexity()
                            ->addCollection()
                            ->addCategory()
                            ->addRegion()
                            ->addDurationType();

        return $this->constructor->getData();
    }
}
