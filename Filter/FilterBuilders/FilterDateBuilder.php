<?php


namespace App\Services\OffersFilter\Filter\FilterBuilders;


use App\Services\OffersFilter\Filter\AFilterBuilder;
use Illuminate\Database\Eloquent\Builder;

class FilterDateBuilder extends AFilterBuilder
{
    public function build() : Builder
    {
        $this->optionConstructor->addOnlyVisible()
            ->addStartDate($this->data);

        return $this->optionConstructor->getQuery();
    }
}
