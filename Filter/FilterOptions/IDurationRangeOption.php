<?php


namespace App\Services\OffersFilter\Filter\FilterOptions;


interface IDurationRangeOption extends IOption
{
    public function getMinDuration() : ?int;
    public function getMaxDuration() : ?int;
}
