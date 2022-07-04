<?php


namespace App\Services\OffersFilter\Filter\FilterOptions;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class AOption implements IOption
{
    /**
     * @var array
     */
    private $data;

    /**
     * CategoryOption constructor.
     * @param array $data
     * @throws ValidationException
     */
    public function __construct(array $data)
    {
        $data = Validator::make($data, static::rules())->validate();
        $this->data = $data;
    }

    /**
     * Return option data
     */
    public function getData()
    {
        return $this->data[static::key()];
    }

    /**
     * Option validation rules
     * @return array
     */
    protected abstract function rules() : array;

    /**
     * Main validated option key
     * @return string
     */
    protected abstract function key() : string;
}
