<?php


namespace App\Services\OffersFilter\FilterData\FilterBodyBuilders;


use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;

class FilterBodyTypeBuilder extends AFilterBodyBuilder
{
    public function build(): array
    {
        $this->constructor->addDurationType();

        return $this->constructor->getData();
    }
}
