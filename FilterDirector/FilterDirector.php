<?php


namespace App\Services\OffersFilter\FilterDirector;


use App\Services\OffersFilter\Filter\AFilterBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterActiveBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterDateBuilder;
use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterBodyBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterBodyDateBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterRangeBodyBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterCategoryBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterSearchTextBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterRangeBuilder;
use Illuminate\Database\Eloquent\Builder;

class FilterDirector extends AFilterDirector
{
    public function build(): array
    {
        //
        $base_query_builder = new FilterActiveBuilder();
        $base_query = $base_query_builder->build();

        //Take options from base query
        $options = self::buildOptions($base_query);

        //build: text query data
        $textsearch_query_builder = new FilterSearchTextBuilder($this->data, $base_query_builder->getQueryConstructor());
        $textsearch_query_builder->build();

        //
        //build: base tours' data
        $category_query_builder = new FilterCategoryBuilder($this->data, $textsearch_query_builder->getQueryConstructor());
        $category_query_builder->build();

        //
        //build: range tours' data
        $range_query_builder = new FilterRangeBuilder($this->data, $category_query_builder->getQueryConstructor());
        $range_query_builder->build();

        //
        //build: date
        $date_query_builder = new FilterDateBuilder($this->data, $range_query_builder->getQueryConstructor());
        $filter_query = $date_query_builder->build();


        //Take filtered data
        $data = $filter_query->get();

        //
        return [
            'data' => $data,
            'options' => $options
        ];
    }

    private function buildOptions(?Builder $query): array
    {
        //
        $base_options_builder = new FilterBodyBuilder($query);
        $base_options = $base_options_builder->build();

        //
        $range_options_builder = new FilterRangeBodyBuilder($query);
        $range_options = $range_options_builder->build();

        //default option data (not necessary)
        $date_options_builder = new FilterBodyDateBuilder();
        $date_options = $date_options_builder->build();

        return [
            'category' => $base_options,
            'range' => $range_options,
            'date' => $date_options
        ];
    }
}
