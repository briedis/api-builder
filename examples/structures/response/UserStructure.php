<?php


use Briedis\ApiBuilder\ApiStructureInterface;
use Briedis\ApiBuilder\StructureBuilder;

class UserStructure implements ApiStructureInterface{
	/**
	 * Get User structure object
	 * @return StructureBuilder
	 */
	public function getStructure(){
		return (new StructureBuilder('User'))
			->int('id', 'Unique identifier')
			->string('username', 'Nickname that will be used in the system')
			->string('firstName', 'Users first name')
			->string('lastName', 'Users last name')
			->string('gender', 'M - male, F - female')->enum(['M', 'F'])->optional()
			->int('signature', 'Provide your favorite quote or something, if you want')->optional()
			->struct('location', new LocationStructure, 'Location object for the user')->optional()
			->int('createdAt', 'Unix timestamp, when user has registered', '');
	}
}