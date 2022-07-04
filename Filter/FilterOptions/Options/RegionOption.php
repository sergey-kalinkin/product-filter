<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class RegionOption extends AOption
{
    protected function rules(): array
    {
        return [
            'regions' => 'required|array',
            'regions.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'regions';
    }
}
