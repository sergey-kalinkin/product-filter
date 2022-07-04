<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class TextOption extends AOption
{
    protected function rules(): array
    {
        return [
            'query' => 'string',
        ];
    }

    protected function key(): string
    {
        return 'query';
    }
}
