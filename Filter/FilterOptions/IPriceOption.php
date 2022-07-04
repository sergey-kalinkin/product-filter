<?php


namespace App\Services\OffersFilter\Filter\FilterOptions;


interface IPriceOption extends IOption
{
    public function getMinPrice() : ?int;
    public function getMaxPrice() : ?int;
}
