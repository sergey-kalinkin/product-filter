<?php


namespace App\Services\OffersFilter\Filter;


interface IFilterOptionConstructor extends IFilter
{
    public function addCategory(array $data) : self;
    public function addRegion(array $data) : self;
    public function addCollection(array $data) : self;
    public function addAllocation(array $data) : self;
    public function addRest(array $data) : self;
    public function addAgeRestriction(array $data) : self;
    public function addSeason(array $data) : self;
    public function addComplexity(array $data) : self;
    public function addSearchText(array $data) : self;
    public function addDurationRange(array $data) : self;
    public function addDurationType(array $data) : self;
    public function addPrice(array $data) : self;
    public function addGroupSize(array $data) : self;
    public function addStartDate(array $data) : self;
    public function addOnlyVisible() : self;
}
