<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;
use App\Services\OffersFilter\Filter\FilterOptions\IDurationRangeOption;

class DurationRangeOption extends AOption implements IDurationRangeOption
{
    protected function rules(): array
    {
        return [
            'duration' => 'required|array',
            'duration.min' => 'required_without:duration.max|nullable|numeric',
            'duration.max' => 'required_without:duration.min|nullable|numeric',
        ];
    }

    protected function key(): string
    {
        return 'duration';
    }

    public function getMinDuration(): ?int
    {
        return $this->getData()['min'] ?? null;
    }

    public function getMaxDuration(): ?int
    {
        return $this->getData()['max'] ?? null;
    }
}
