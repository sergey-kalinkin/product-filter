<?php


namespace App\Services\OffersFilter\Filter\FilterOptions;


interface IDurationTypeOption extends IOption
{
    public function getDurationType() : string;
}
