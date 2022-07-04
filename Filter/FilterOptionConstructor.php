<?php


namespace App\Services\OffersFilter\Filter;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\AgeRestrictionOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\AllocationOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\CategoryOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\CollectionOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\ComplexityOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\DateOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\DurationOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\DurationRangeOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\DurationTypeOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\GroupSizeOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\PriceOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\RegionOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\RestOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\SeasonOption;
use App\Services\OffersFilter\Filter\FilterOptions\Options\TextOption;
use Faker\Provider\ar_JO\Text;
use Illuminate\Database\Eloquent\Builder;

class FilterOptionConstructor implements IFilterOptionConstructor
{
    /**
     * @var IFilterConstructor
     */
    private $constructor;

    public function __construct(IFilterConstructor $constructor)
    {
        $this->constructor = $constructor;
    }

    public function addCategory(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new CategoryOption($data);
            $this->constructor->addCategory($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addRegion(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new RegionOption($data);
            $this->constructor->addRegion($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addCollection(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new CollectionOption($data);
            $this->constructor->addCollection($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addAllocation(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new AllocationOption($data);
            $this->constructor->addAllocationType($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addRest(array $data) : IFilterOptionConstructor
    {
        try{
            $this->constructor->addKinds();
            $option = new RestOption($data);
            $this->constructor->addRestType($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addAgeRestriction(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new AgeRestrictionOption($data);
            $this->constructor->addAgeRestriction($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addSeason(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new SeasonOption($data);
            $this->constructor->addSeason($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addComplexity(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new ComplexityOption($data);
            $this->constructor->addComplexity($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addSearchText(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new TextOption($data);
            $this->constructor->addSearchText($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addDurationRange(array $data): IFilterOptionConstructor
    {
        try{
            $option = new DurationRangeOption($data);
            $this->constructor->addDurationRange($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addDurationType(array $data): IFilterOptionConstructor
    {
        try{
            $option = new DurationTypeOption($data);
            $this->constructor->addDurationType($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addPrice(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new PriceOption($data);
            $this->constructor->addPrice($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addGroupSize(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new GroupSizeOption($data);
            $this->constructor->addGroupSize($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addStartDate(array $data) : IFilterOptionConstructor
    {
        try{
            $option = new DateOption($data);
            $this->constructor->addStartDate($option);
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function addOnlyVisible(): IFilterOptionConstructor
    {
        try{
            $this->constructor->addOnlyVisible();
        }
        catch (\Throwable $t) {
            \Log::warning($t->getMessage());
        }
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->constructor->getQuery();
    }
}
