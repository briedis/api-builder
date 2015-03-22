<?php


namespace Briedis\ApiBuilder\Items;


abstract class BaseItem{
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
	public $isFixedValues = false;

	/**
	 * List of valid values. Is used only if isEnum is set
	 * @var array
	 */
	public $validValues = [];

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
			return $type . '[]';
		}

		if($this->isFixedValues){
			return '{' . implode(', ', $this->validValues) . '}';
		}

		return $type;
	}

	public function validate($value){
		if($this->isArray){
			return $this->validateArray($value);
		}

		if($this->isFixedValues){
			return $this->validateFixedValues($value);
		}

		return $this->validateValue($value);
	}

	/**
	 * Check if all values are the needed type
	 * @param array $values
	 * @return bool
	 */
	protected function validateArray($values){
		if(!is_array($values)){
			return false;
		}

		foreach($values as $v){
			if($this->isFixedValues && !$this->validateFixedValues($v)){
				return false;
			} elseif(!$this->validateValue($v)){
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if value is one of allowed values
	 * @param mixed $value
	 * @return bool
	 */
	protected function validateFixedValues($value){
		return in_array($value, $this->validValues, true);
	}

	/**
	 * Check if this value is valid for this item type
	 * @param mixed $value
	 * @return bool
	 */
	abstract protected function validateValue($value);
}