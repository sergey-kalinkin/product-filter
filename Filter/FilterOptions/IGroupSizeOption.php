<?php


namespace App\Services\OffersFilter\Filter\FilterOptions;


interface IGroupSizeOption extends IOption
{
    public function getMinGroupSize() : ?int;
    public function getMaxGroupSize() : ?int;
}
