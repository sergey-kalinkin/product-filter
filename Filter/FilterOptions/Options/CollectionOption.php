<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class CollectionOption extends AOption
{
    protected function rules(): array
    {
        return [
            'collections' => 'required|array',
            'collections.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'collections';
    }
}
