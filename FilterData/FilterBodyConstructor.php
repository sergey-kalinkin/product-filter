<?php


namespace App\Services\OffersFilter\FilterData;


use App\Activity;
use App\ActivityRate;
use App\Allocation;
use App\Category;
use App\Complexity;
use App\Kind;
use App\MinimumAge;
use App\Region;
use App\Collection as DBCollections;
use App\Season;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FilterBodyConstructor implements IFilterBodyConstructor
{
    private $filterBody = [];

    /**
     * @var Collection
     */
    private $activitiesData;

    public function __construct(?Builder $builder = null)
    {
        if(self::isActivity($builder))
            $this->activitiesData = $builder->get();
    }

    private function combine(array $item) : IFilterBodyConstructor
    {
        $this->filterBody =
            array_merge_recursive($this->filterBody, $item);
        return $this;
    }

    public function addCategory(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return  self::combine([
                'categories' => Category::all(),
            ]);

        $data = $this->activitiesData->pluck('id')->toArray();
        $categories = Category::getActiveByRelationActivities('category', $data);
        return  self::combine([
            'categories' => $categories,
        ]);
    }

    public function addRegion(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'regions' => Region::all(),
            ]);

        $data = $this->activitiesData->pluck('region_id')->toArray();
        $regions = Region::getActiveByIds($data);
        return self::combine([
            'regions' => $regions,
        ]);
    }

    public function addCollection(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'collections' => DBCollections::all(),
            ]);

        $data = $this->activitiesData->pluck('id')->toArray();
        $collections = DBCollections::getActiveByRelationActivities('collection', $data);
        return self::combine([
            'collections' => $collections,
        ]);
    }

    public function addAllocation(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'allocations' => Allocation::all(),
            ]);

        $data = $this->activitiesData->pluck('allocation_id')->toArray();
        $alloc = Allocation::getActiveByIds($data);
        return self::combine([
            'allocations' => $alloc,
        ]);
    }

    public function addRest(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'kinds' => Kind::all(),
            ]);

        $data = $this->activitiesData->pluck('kind_id')->toArray();
        $kinds = Kind::getActiveByIds($data);
        return self::combine([
            'kinds' => $kinds,
        ]);
    }

    public function addAgeRestriction(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'minimumAges' => MinimumAge::all(),
            ]);

        $data = $this->activitiesData->pluck('minimum_age_id')->toArray();
        $ages = MinimumAge::getActiveByIds($data);
        return self::combine([
            'minimumAges' => $ages,
        ]);
    }

    public function addSeason(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'seasons' => Season::all(),
            ]);

        $data = $this->activitiesData->pluck('season_id')->toArray();
        $seasons = Season::getActiveByIds($data);
        return self::combine([
            'seasons' => $seasons,
        ]);
    }

    public function addComplexity(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'complexities' => Complexity::all(),
            ]);

        $data = $this->activitiesData->pluck('complexity_id')->toArray();
        $compl = Complexity::getByIds($data);
        return self::combine([
            'complexities' => $compl,
        ]);
    }

    public function addDurationRange(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData)) {

            $act = Activity::all()->pluck('duration');

            return self::combine([
                'duration' => [
                    'min' => $act->min() ? (int)$act->min() : null,
                    'max' => $act->max() ? (int)$act->max() : null,
                ],
            ]);
        }

        $data = $this->activitiesData->pluck('duration');
        return self::combine([
            'duration' => [
                'min' => $data->min() ? (int)$data->min() : null,
                'max' => $data->max() ? (int)$data->max() : null,
            ],
        ]);
    }

    public function addDurationType(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'duration' => [
                    'type' => 'days',
                ],
            ]);

        $data = $this->activitiesData->pluck('duration_period')->first() ?? 'day';
        return self::combine([
            'duration' => [
                'type' => "{$data}s"
            ],
        ]);
    }

    public function addPrice(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData)) {

            $data = ActivityRate::all()->pluck('id')->toArray();
            $ratesPrices = ActivityRate::getPricesByActivities($data)->map(function ($price) {
                return (int)$price;
            });

            return self::combine([
                'price' => [
                    'min' => $ratesPrices->min() ?? 1,
                    'max' => $ratesPrices->max() ?? 1
                ]
            ]);
        }

        $data = $this->activitiesData->pluck('id')->toArray();
        $ratesPrices = ActivityRate::getPricesByActivities($data)->map(function ($price) {
            return (int)$price;
        });
        return self::combine([
            'price' => [
                'min' => $ratesPrices->min() ?? 1,
                'max' => $ratesPrices->max() ?? 1
            ]
        ]);
    }

    public function addGroupSize(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData)) {
            $act = Activity::all();

            return self::combine([
                'groupSize' => [
                    'min' => $act->min('group_size_min') ?? 1,
                    'max' => $act->max('group_size_max') ?? 1,
                ],
            ]);
        }

        return self::combine([
            'groupSize' => [
                'min' => $this->activitiesData->min('group_size_min') ?? 1,
                'max' => $this->activitiesData->max('group_size_max') ?? 1,
            ],
        ]);
    }

    public function addStartDate(): IFilterBodyConstructor
    {
        if(!isset($this->activitiesData))
            return self::combine([
                'date' => [
                    'type' => 'full',
                    'date' => null,
                    'month' => null,
                    'flexibility' => 'flexible',
                ],
            ]);

        return self::combine([
            'date' => [
                'type' => 'full',
                'date' => $this->activitiesData->min('start_date'),
                'month' => null,
                'flexibility' => 'flexible',
            ],
        ]);
    }

    private function isActivity(?Builder $builder): bool
    {
        return
            isset($builder) &&
            //
            $activity_table_name = Activity::getModel()->getTable()
                ===
            $building_table_name = $builder->getModel()->getTable();
    }

    public function getData(): array
    {
        return $this->filterBody;
    }
}
