<?php


namespace App\Services\OffersFilter\Filter;


use App\Services\OffersFilter\Filter\FilterOptions\IDateOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationRangeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationTypeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IGroupSizeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IOption;
use App\Services\OffersFilter\Filter\FilterOptions\IPriceOption;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface IFilter интерфейс для класса строителя
 * добавляет к классу модели ограничения на выборку по определенному критерию
 * @package App\Services\OffersFilter\Filter
 */
interface IFilterConstructor extends IFilter
{
    public function addSearchText(IOption $textquery) : self;
    public function addCategory(IOption $categoryIDs) : self;
    public function addRegion(IOption $regionIDs) : self;
    public function addCollection(IOption $collectionIDs) : self;
    public function addAllocationType(IOption $allocationIDs) : self;
    public function addRestType(IOption $kindIDs) : self;
    public function addAgeRestriction(IOption $ageIDs) : self;
    public function addSeason(IOption $seasonIDs) : self;
    public function addComplexity(IOption $complexityIDs) : self;
    public function addDurationRange(IDurationRangeOption $duration) : self;
    public function addDurationType(IDurationTypeOption $duration) : self;
    public function addPrice(IPriceOption $price) : self;
    public function addGroupSize(IGroupSizeOption $groupSize) : self;
    public function addStartDate(IDateOption $date) : self;
    public function addOnlyVisible() : self;
}
