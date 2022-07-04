<?php


namespace App\Services\OffersFilter\FilterData;


use Illuminate\Database\Eloquent\Builder;

interface IFilterBodyConstructor extends IFilterBody
{
    public function addCategory() : self;
    public function addRegion() : self;
    public function addCollection() : self;
    public function addAllocation() : self;
    public function addRest() : self;
    public function addAgeRestriction() : self;
    public function addSeason() : self;
    public function addComplexity() : self;
    public function addDurationRange() : self;
    public function addDurationType() : self;
    public function addPrice() : self;
    public function addGroupSize() : self;
    public function addStartDate() : self;
}
