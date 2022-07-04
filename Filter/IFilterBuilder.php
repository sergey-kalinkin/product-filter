<?php


namespace App\Services\OffersFilter\Filter;


use Illuminate\Database\Eloquent\Builder;

interface IFilterBuilder
{
    public function build() : Builder;
    public function getQueryOptionConstructor() :IFilterOptionConstructor;
    public function getQueryConstructor() :IFilterConstructor;
}
