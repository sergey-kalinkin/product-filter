<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDateOption;
use Carbon\Carbon;

class DateOption extends AOption implements IDateOption
{
    protected function rules(): array
    {
        return [
            'date' => 'required|array',
            'date.date' => 'exclude_if:date.type,monthOnly|required|date',
            'date.month' => 'exclude_if:date.type,full|required|numeric',
            'date.type' => 'required|in:full,monthOnly',
            'date.flexibility' => 'required|in:exact,oneDayFlex,flexible',
        ];
    }

    protected function key(): string
    {
        return 'date';
    }

    public function getDate(): Carbon
    {
        switch ($this->getData()['type']) {
            case 'full':
                return Carbon::createFromFormat('Y-m-d', $this->getData()['date']);
            case 'monthOnly':
                return Carbon::create(Carbon::now()->year, $this->getData()['month'], 15);
            default:
                return Carbon::now();
        }
    }

    public function getDateInterval(): array
    {
        if($this->getData()['type'] === 'monthOnly') {
            return [static::getDate()->subDays(15), static::getDate()->addDays(15)];
        }

        if($this->getData()['type'] === 'full') {
            switch ($this->getData()['flexibility']) {
                case 'exact':
                    return [static::getDate(), static::getDate()];
                case 'oneDayFlex':
                    return [static::getDate()->subDay(), static::getDate()->addDay()];
                case 'flexible':
                    return [static::getDate(), null];
            }
        }

        return [static::getDate(), static::getDate()];
    }

    public function isRangeDate(): bool
    {
        return !in_array($this->getData()['flexibility'], ['exact']);
    }
}
