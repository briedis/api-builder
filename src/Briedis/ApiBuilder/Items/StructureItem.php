<?php


namespace Briedis\ApiBuilder\Items;


use Briedis\ApiBuilder\StructureBuilder;

class StructureItem extends BaseItem
{
    /** @var StructureBuilder */
    public $structure;

    public function validateValue($value)
    {
        throw new \RuntimeException('Cannot validate a structure');
    }
}