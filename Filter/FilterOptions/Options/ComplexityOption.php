<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class ComplexityOption extends AOption
{
    protected function rules(): array
    {
        return [
            'complexities' => 'required|array',
            'complexities.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'complexities';
    }
}
