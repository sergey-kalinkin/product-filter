<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;
use App\Services\OffersFilter\Filter\FilterOptions\IGroupSizeOption;
use App\Services\OffersFilter\Filter\FilterOptions\IPriceOption;

class GroupSizeOption extends AOption implements IGroupSizeOption
{
    protected function rules(): array
    {
        return [
            'groupSize' => 'required|array',
            'groupSize.min' => 'required_without:groupSize.max|nullable|numeric',
            'groupSize.max' => 'required_without:groupSize.min|nullable|numeric',
        ];
    }

    protected function key(): string
    {
        return 'groupSize';
    }

    public function getMinGroupSize(): ?int
    {
        return $this->getData()['min'] ?? null;
    }

    public function getMaxGroupSize(): ?int
    {
        return $this->getData()['max'] ?? null;
    }
}
