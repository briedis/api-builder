<?php


use Briedis\ApiBuilder\StructureInterface;
use Briedis\ApiBuilder\StructureBuilder;

class UserStructure implements StructureInterface{
	/**
	 * Get User structure object
	 * @return StructureBuilder
	 */
	public function getStructure(){
		return (new StructureBuilder('User'))
			->int('id', 'Unique identifier')
			->str('username', 'Nickname that will be used in the system')
			->str('firstName', 'Users first name')
			->str('lastName', 'Users last name')
			->str('gender', 'M - male, F - female')->values(['M', 'F'])->optional()
			->int('signature', 'Provide your favorite quote or something, if you want')->optional()
			->struct('location', new LocationStructure, 'Location object for the user')->optional()
			->int('createdAt', 'Unix timestamp, when user has registered');
	}
}