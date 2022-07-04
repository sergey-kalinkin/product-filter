<?php


namespace App\Services\OffersFilter\FilterDirector;


use App\Services\OffersFilter\Filter\FilterBuilders\FilterActiveBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterBaseCategoryBuilder;
use App\Services\OffersFilter\Filter\FilterBuilders\FilterBaseRegionBuilder;
use App\Services\OffersFilter\FilterData\AFilterBodyBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterBodyDateBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterBodyTypeBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterCategoryBodyBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterRangeBodyBuilder;
use App\Services\OffersFilter\FilterData\FilterBodyBuilders\FilterRegionBodyBuilder;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilterDirector extends AFilterDirector
{
    public function build() : array
    {
        //
        //
        $base_query_builder = new FilterBaseCategoryBuilder($this->data);
        $base_query_builder->build();

        //
        $active_query_builder = new FilterActiveBuilder([], $base_query_builder->getQueryConstructor());
        $base_query = $active_query_builder->build();

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
        $base_body = new FilterCategoryBodyBuilder($query);
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
