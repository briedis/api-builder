<?php


namespace Briedis\ApiBuilder\Items;


class BaseItem{
	const TYPE = 'mixed';

	/**
	 * Name of the parameter
	 * @var string
	 */
	public $name = '';

	/**
	 * Description for this parameter
	 * @var string
	 */
	public $description = '';

	/**
	 * Is optional. All parameters are required by default
	 * @var bool
	 */
	public $isOptional = false;

	/**
	 * Is type an array
	 * @var bool
	 */
	public $isArray = false;

	/**
	 * Is enumerable type, has a list of valid values
	 * @var bool
	 */
	public $isEnum = false;

	/**
	 * List of valid values. Is used only if isEnum is set
	 * @var array
	 */
	public $enumValues = [];

	/**
	 * @param string $name Parameters name
	 * @param string $description
	 */
	public function __construct($name = '', $description = ''){
		$this->name = $name;
		$this->description = $description;
	}

	/**
	 * Get the type name
	 * @return string
	 */
	public function getDisplayTypeName(){
		$type = static::TYPE;

		if($this instanceof Structure){
			$type = $this->structure->getStructureName();
		}

		if($this->isArray){
			return $type . ' [ ]';
		}

		if($this->isEnum){
			return '{' . implode(', ', $this->enumValues) . '}';
		}

		return $type;
	}
}