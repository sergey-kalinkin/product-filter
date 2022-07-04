<?php


namespace App\Services\OffersFilter\FilterDirector;


abstract class AFilterDirector implements IFilterDirector
{
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
}
