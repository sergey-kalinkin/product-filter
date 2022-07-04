<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class AllocationOption extends AOption
{
    protected function rules(): array
    {
        return [
            'allocations' => 'required|array',
            'allocations.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'allocations';
    }
}
