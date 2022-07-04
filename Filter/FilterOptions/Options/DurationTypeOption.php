<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationRangeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationTypeOption;

class DurationTypeOption extends AOption implements IDurationTypeOption
{
    protected function rules(): array
    {
        return [
            'duration' => 'required|array',
            'duration.type' => 'required|in:minutes,days,hours',
        ];
    }

    protected function key(): string
    {
        return 'duration';
    }

    public function getDurationType(): string
    {
        return rtrim($this->getData()['type'],'s');
    }
}
