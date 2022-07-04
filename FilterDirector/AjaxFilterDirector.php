<?php


namespace App\Services\OffersFilter\FilterDirector;


use App\Services\OffersFilter\Filter\FilterBuilders\FilterActiveBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterCategoryBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterDateBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterRangeBuilder;
use Illuminate\Database\Eloquent\Collection;

class AjaxFilterDirector extends AFilterDirector
{

    public function build() : array
    {
        //
        //build: active tour items
        $base_query_builder = new FilterActiveBuilder();
        $base_query_builder->build();

        //
        //build: base tours' data
        $category_query_builder = new FilterCategoryBuilder($this->data, $base_query_builder->getQueryConstructor());
        $category_query_builder->build();

        //
        //build: range tours' data
        $range_query_builder = new FilterRangeBuilder($this->data, $category_query_builder->getQueryConstructor());
        $range_query_builder->build();

        //
        //build: date
        $date_query_builder = new FilterDateBuilder($this->data, $range_query_builder->getQueryConstructor());
        $filter_query = $date_query_builder->build();

        //
        //
        $filter_data = $filter_query->get();

        //
        return [
            $filter_data
        ];
    }
}
