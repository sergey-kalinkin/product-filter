<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class RestOption extends AOption
{
    protected function rules(): array
    {
        return [
            'kinds' => 'required|array',
            'kinds.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'kinds';
    }
}
