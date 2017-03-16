<?php


namespace Briedis\ApiBuilder\Items;


class IntegerItem extends BaseItem
{
    const TYPE = 'integer';

    public function validateValue($value)
    {
        return is_scalar($value) && (string)(int)$value === (string)$value;
    }
}