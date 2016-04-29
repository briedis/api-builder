<?php


use Briedis\ApiBuilder\StructureBuilder;
use Briedis\ApiBuilder\StructureInterface;

class LocationStructure implements StructureInterface
{
    /**
     * @return \Briedis\ApiBuilder\StructureBuilder
     */
    public function getStructure()
    {
        return (new StructureBuilder('Location'))
            ->float('lat', 'Latitude coordinate, in decimal format')
            ->float('lon', 'Longitude coordinate, in decimal format');
    }
}