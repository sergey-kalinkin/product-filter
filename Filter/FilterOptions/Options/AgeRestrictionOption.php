<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class AgeRestrictionOption extends AOption
{
    protected function rules(): array
    {
        return [
            'minimumAges' => 'required|array',
            'minimumAges.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'minimumAges';
    }
}
