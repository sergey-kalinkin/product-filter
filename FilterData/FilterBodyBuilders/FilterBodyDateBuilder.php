<?php


namespace App\Services\OffersFilter\FilterData\FilterBodyBuilders;


use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;

class FilterBodyDateBuilder extends AFilterBodyBuilder
{
    public function build(): array
    {
        $this->constructor->addStartDate();

        return $this->constructor->getData();
    }
}
