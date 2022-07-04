<?php


namespace App\Services\OffersFilter\Filter;


use App\Activity;
use App\ActivityInterval;
use App\Services\OffersFilter\Filter\FilterOptions\IDateOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationRangeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationTypeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IGroupSizeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IOption;
use App\Services\OffersFilter\Filter\FilterOptions\IPriceOption;
use Illuminate\Database\Eloquent\Builder;

class FilterConstructor implements IFilterConstructor
{
    /**
     * @var Activity|Builder
     */
    private $query;

    public function __construct(IFilter $filter = null)
    {
        $this->query = self::isActivity($filter) ?
            $filter->getQuery() : Activity::query();
    }

    public function addCategory(IOption $categoryIDs): IFilterConstructor
    {
        $idx = $categoryIDs->getData();
        $this->query->whereHas('activityCategories', function ($subquery) use ($idx) {
            $subquery->whereIn('category_id', $idx);
        });
        return $this;
    }

    public function addRegion(IOption $regionIDs): IFilterConstructor
    {
        $idx = $regionIDs->getData();
        $this->query->whereIn('region_id', $idx);
        return $this;
    }

    public function addCollection(IOption $collectionIDs): IFilterConstructor
    {
        $idx = $collectionIDs->getData();
        $this->query->whereHas('activityCollections', function ($subquery) use ($idx) {
            $subquery->whereIn('collection_id', $idx);
        });
        return $this;
    }

    public function addAllocationType(IOption $allocationIDs): IFilterConstructor
    {
        $idx = $allocationIDs->getData();
        $this->query->whereIn('allocation_id', $idx);
        return $this;
    }

    public function addRestType(IOption $kindIDs): IFilterConstructor
    {
        $idx = $kindIDs->getData();

        $this->query->whereIn('activity_kinds.kind_id', $idx);

        return $this;
    }

    public function addAgeRestriction(IOption $ageIDs): IFilterConstructor
    {
        $idx = $ageIDs->getData();
        $this->query->whereIn('minimum_age_id', $idx);
        return $this;
    }

    public function addSeason(IOption $seasonIDs): IFilterConstructor
    {
        $idx = $seasonIDs->getData();
        $this->query->whereIn('season_id', $idx);
        return $this;
    }

    public function addComplexity(IOption $complexityIDs): IFilterConstructor
    {
        $idx = $complexityIDs->getData();
        $this->query->whereIn('complexity_id', $idx);
        return $this;
    }

    public function addSearchText(IOption $text): IFilterConstructor
    {
        $query = $text->getData();
        $this->query->where('name', 'like', "%" . $query . "%");
        $this->query->orWhere('description', 'like', "%" . $query . "%");
        return $this;
    }

    public function addDurationRange(IDurationRangeOption $duration): IFilterConstructor
    {
        $min_duration = $duration->getMinDuration();
        $max_duration = $duration->getMaxDuration();

        $is_only_max_duration_defined = isset($max_duration) && !isset($min_duration);
        $is_only_min_duration_defined = !isset($max_duration) && isset($min_duration);
        $are_max_min_duration_defined = isset($max_duration) && isset($min_duration);

        $this->query
            ->when($are_max_min_duration_defined, function ($query) use ($min_duration, $max_duration) {
                $query->whereBetween('duration', [$min_duration, $max_duration]);
            })
            ->when($is_only_min_duration_defined, function ($query) use ($min_duration) {
                $query->where('duration', '>=', $min_duration);
            })
            ->when($is_only_max_duration_defined, function ($query) use ($max_duration) {
                $query->where('duration', '<=', $max_duration);
            });

        return $this;
    }

    public function addDurationType(IDurationTypeOption $duration): IFilterConstructor
    {
        $this->query
            ->where('duration_period', $duration->getDurationType());

        return $this;
    }

    public function addPrice(IPriceOption $price): IFilterConstructor
    {
        $this->query->whereHas('rates', function ($subquery) use ($price) {

            $min_price = $price->getMinPrice();
            $max_price = $price->getMaxPrice();

            $is_only_max_price_defined = isset($max_price) && !isset($min_price);
            $is_only_min_price_defined = !isset($max_price) && isset($min_price);
            $are_max_min_price_defined = isset($max_price) && isset($min_price);

            $subquery
                ->when($are_max_min_price_defined, function ($query) use ($min_price, $max_price) {
                    $query->whereRaw("cast(price as unsigned) between {$min_price} and {$max_price}");
                })
                ->when($is_only_min_price_defined, function (Builder $query) use ($min_price) {
                    $query->whereRaw('cast(price as unsigned) >=' . $min_price);
                })
                ->when($is_only_max_price_defined, function (Builder $query) use ($max_price) {
                    $query->whereRaw('cast(price as unsigned) <=' . $max_price);
                });
        });

        return $this;
    }

    public function addGroupSize(IGroupSizeOption $groupSize): IFilterConstructor
    {
        $min_groupSize = $groupSize->getMinGroupSize();
        $max_groupSize = $groupSize->getMaxGroupSize();

        $is_only_max_group_size_defined = isset($max_groupSize) && !isset($min_groupSize);
        $is_only_min_group_size_defined = !isset($max_groupSize) && isset($min_groupSize);
        $are_max_min_group_size_defined = isset($max_groupSize) && isset($min_groupSize);

        $this->query
            ->when($are_max_min_group_size_defined, function (Builder $query) use ($min_groupSize, $max_groupSize) {

                $query->where(function (Builder $query) use ($min_groupSize, $max_groupSize) {
                    $query
                        ->orWhereBetween('group_size_min', [$min_groupSize, $max_groupSize])
                        ->orWhereBetween('group_size_max', [$min_groupSize, $max_groupSize])
                        ->orWhere(function (Builder $query) use ($min_groupSize, $max_groupSize) {
                            $query
                                ->where('group_size_min', '<=', $min_groupSize)
                                ->where('group_size_max', '>=', $max_groupSize);
                        });
                });
            })
            ->when($is_only_min_group_size_defined, function ($query) use ($min_groupSize) {
                $query->where('group_size_min', '>=', $min_groupSize);
            })
            ->when($is_only_max_group_size_defined, function ($query) use ($max_groupSize) {
                $query->where('group_size_max', '<=', $max_groupSize);
            });

        return $this;
    }

    public function addStartDate(IDateOption $date): IFilterConstructor
    {
        $this->query
            ->when($date->isRangeDate(), function (Builder $query) use ($date) {
                    $query->whereHas('intervals', function (Builder $subquery) use ($date) {
                        [$start_day, $end_day] = $date->getDateInterval();

                        $is_only_start_date_defined = isset($start_day) && !isset($end_day);
                        $is_only_end_date_defined = !isset($start_day) && isset($end_day);
                        $are_start_end_date_defined = isset($start_day) && isset($end_day);

                        $subquery
                            ->when($are_start_end_date_defined, function (Builder $query) use ($start_day, $end_day) {
                                $start_day = $start_day->toDateString();
                                $end_day = $end_day->toDateString();
                                $query->where(function (Builder $query) use ($start_day, $end_day) {
                                    $query
                                        ->orWhereBetween('start_date', [$start_day, $end_day])
                                        ->orWhereBetween('end_date', [$start_day, $end_day])
                                        ->orWhere(function (Builder $query) use ($start_day, $end_day) {
                                            $query
                                                ->where('start_date', '<=', $start_day)
                                                ->where('end_date', '>=', $end_day);
                                        });
                                });
                            })
                            ->when($is_only_start_date_defined, function ($query) use ($start_day) {
                                $query->where('start_date', '>=', $start_day->toDateString());
                            })
                            ->when($is_only_end_date_defined, function ($query) use ($end_day) {
                                $query->where('end_date', '<=', $end_day->toDateString());
                            });
                    });
            })
            ->when(!$date->isRangeDate(), function ($query) use ($date) {
                $query->whereHas('intervals', function (Builder $subquery) use ($date) {
                $subquery->where('start_date', '<=', $date->getDate()->toDateString())
                    ->where('end_date', '>=', $date->getDate()->toDateString());
            });
            });

        return $this;
    }

    public function addOnlyVisible(): IFilterConstructor
    {
        $this->query
            ->where('is_active', '=', true);

        return $this;
    }

    public function addKinds(): IFilterConstructor
    {
        $this->query
            ->leftJoin('activity_kinds', 'activity_kinds.activity_id', '=', 'activities.id')
            ->groupBy('activities.id')
            ->select(['activities.*']);

        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }

    private function isActivity(?IFilter $filter): bool
    {
        return
            isset($filter) &&
            //
            $activity_table_name = Activity::getModel()->getTable()
                ===
                $filtering_table_name = $filter->getQuery()->getModel()->getTable();
    }
}
