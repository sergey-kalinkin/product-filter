<?php


namespace App\Services\OffersFilter\Filter;


use Illuminate\Database\Eloquent\Builder;

interface IFilter
{
    public function getQuery() : Builder;
}
