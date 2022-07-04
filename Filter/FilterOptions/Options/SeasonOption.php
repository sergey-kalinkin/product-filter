<?php


namespace App\Services\OffersFilter\Filter\FilterOptions\Options;


use App\Services\OffersFilter\Filter\FilterOptions\AOption;

class SeasonOption extends AOption
{
    protected function rules(): array
    {
        return [
            'seasons' => 'required|array',
            'seasons.*' => 'required|integer',
        ];
    }

    protected function key(): string
    {
        return 'seasons';
    }
}
