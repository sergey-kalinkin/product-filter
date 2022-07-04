<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class CategoryOption extends AOption
{
    protected function rules(): array
    {
        return [
            'categories' => 'required|array',
            'categories.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'categories';
    }
}
