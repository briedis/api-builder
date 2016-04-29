<?php


namespace Briedis\ApiBuilder\Items;


class IntegerItem extends BaseItem
{
    const TYPE = 'integer';

    public function validateValue($value)
    {
        return (string)(int)$value === (string)$value;
    }
}