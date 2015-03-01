<?php


namespace Briedis\ApiBuilder\Exceptions;


use Briedis\ApiBuilder\Items\BaseItem;
use Exception;

class InvalidStructureException extends Exception{
	/**
	 * @var BaseItem[] [name => item, ..]
	 */
	private $badFields = [];

	/**
	 * @var string[] Field names
	 */
	private $unexpectedFields = [];

	/**
	 * @var BaseItem[] [name => item, ..]
	 */
	private $missingFields = [];

	/**
	 * Attach a bad field
	 * @param string $name
	 * @param BaseItem $expectedItem
	 */
	public function addBadField($name, BaseItem $expectedItem){
		$this->badFields[$name] = $expectedItem;
	}

	/**
	 * Attach a field that was given, but was unexpected
	 * @param $name
	 */
	public function addUnexpectedField($name){
		$this->unexpectedFields[] = $name;
	}

	/**
	 * Get array with fields with errors [field name => expected item]
	 * @return BaseItem[]
	 */
	public function getBadFields(){
		return $this->badFields;
	}

	/**
	 * @return bool
	 */
	public function hasErrors(){
		return $this->badFields || $this->unexpectedFields || $this->missingFields;
	}

	/**
	 * @return array
	 */
	public function getUnexpectedFields(){
		return $this->unexpectedFields;
	}

	/**
	 * @return array
	 */
	public function getMissingFields(){
		return $this->missingFields;
	}

	/**
	 * Add a missing field
	 * @param string $name
	 * @param BaseItem $expectedItem
	 */
	public function addMissingField($name, BaseItem $expectedItem){
		$this->missingFields[$name] = $expectedItem;
	}
}