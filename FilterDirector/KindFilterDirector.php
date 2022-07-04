<?php


namespace App\Services\OffersFilter\FilterDirector;


use App\Services\OffersFilter\Filter\FilterBuilders\FilterBaseKindBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterBaseRegionBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterBodyDateBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterKindBodyBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterRangeBodyBuilder;
use Illuminate\Database\Eloquent\Builder;

class KindFilterDirector extends AFilterDirector
{
    public function build() : array
    {
        //
        //build base tours' query
        $base_query_builder = new FilterBaseKindBuilder($this->data);
        $base_query_builder->build();

        //
        $active_query_builder = new FilterBaseRegionBuilder($this->data, $base_query_builder->getQueryConstructor());
        $base_query = $active_query_builder->build();

        //
        $options = self::buildOptions($base_query);

        //
        $data = $base_query->get();

        //
        return [
            'data' => $data,
            'options' => $options
        ];
    }

    private function buildOptions(?Builder $query): array
    {
        //#
        //->build base filter body (not necessary)
        $base_body = new FilterKindBodyBuilder($query);
        $base_options = $base_body->build();

        //->build body options with range data
        $range_body = new FilterRangeBodyBuilder($query);
        $range_options = $range_body->build();

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
