<?php


use Briedis\ApiBuilder\StructureBuilder;

class GetUsersStructure implements \Briedis\ApiBuilder\StructureInterface {
	/**
	 * Get the structure object
	 * @return \Briedis\ApiBuilder\StructureBuilder
	 */
	public function getStructure(){
		return (new StructureBuilder)
			->int('userId', 'Array of user ids you want to fetch')->multiple()
			->int('offset', 'For paging purposes')->optional()
			->int('count', 'Amount of users to fetch. Defaults to 20')->optional();
	}
}