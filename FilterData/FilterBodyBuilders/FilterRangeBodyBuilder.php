<?php


namespace App\Services\OffersFilter\FilterData\FilterBodyBuilders;


use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;

class FilterRangeBodyBuilder extends AFilterBodyBuilder
{
    public function build(): array
    {
        $this->constructor  ->addPrice()
                            ->addDurationRange()
                            ->addGroupSize();

        return $this->constructor->getData();
    }
}
