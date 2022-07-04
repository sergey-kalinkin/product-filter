<?php


namespace App\Services\OffersFilter\Filter\FilterOptions;


use Carbon\Carbon;

interface IDateOption extends IOption
{
    public function getDate() : Carbon;
    public function getDateInterval() : array;
    public function isRangeDate() : bool;
}
