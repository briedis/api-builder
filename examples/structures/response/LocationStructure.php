<?php


use Briedis\ApiBuilder\StructureInterface;
use Briedis\ApiBuilder\StructureBuilder;

class LocationStructure implements StructureInterface {
	/**
	 * @return \Briedis\ApiBuilder\StructureBuilder
	 */
	public function getStructure(){
		return (new StructureBuilder('Location'))
			->float('lat', 'Latitude coordinate, in decimal format')
			->float('lon', 'Longitude coordinate, in decimal format');
	}
}