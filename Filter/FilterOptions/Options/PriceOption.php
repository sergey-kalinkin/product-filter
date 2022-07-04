<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;
use App\Services\OffersFilter\Filter\FilterOptions\IPriceOption;

class PriceOption extends AOption implements IPriceOption
{
    protected function rules(): array
    {
        return [
            'price' => 'required|array',
            'price.min' => 'required_without:price.max|nullable|numeric',
            'price.max' => 'required_without:price.min|nullable|numeric',
        ];
    }

    protected function key(): string
    {
        return 'price';
    }

    public function getMinPrice(): ?int
    {
        return $this->getData()['min'] ?? null;
    }

    public function getMaxPrice(): ?int
    {
        return $this->getData()['max'] ?? null;
    }
}
