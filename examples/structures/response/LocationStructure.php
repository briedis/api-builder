<?php


use Briedis\ApiBuilder\ApiStructureInterface;
use Briedis\ApiBuilder\StructureBuilder;

class LocationStructure implements ApiStructureInterface {
	/**
	 * @return \Briedis\ApiBuilder\StructureBuilder
	 */
	public function getStructure(){
		return (new StructureBuilder('Location'))
			->float('lat', 'Latitude coordinate, in decimal format')
			->float('lon', 'Longitude coordinate, in decimal format');
	}
}