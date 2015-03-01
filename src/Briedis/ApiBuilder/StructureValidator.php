<?php


namespace Briedis\ApiBuilder;


use Briedis\ApiBuilder\Exceptions\InvalidParameterTypeException;
use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Briedis\ApiBuilder\Exceptions\UnexpectedParameterException;
use Briedis\ApiBuilder\Items\Structure;

class StructureValidator{

	/** @var StructureBuilder */
	private $structure;

	/**
	 * @param StructureBuilder $structure Structure to be validated against
	 */
	public function __construct(StructureBuilder $structure){
		$this->structure = $structure;
	}

	/**
	 * Validate an array of input against a given structure
	 * @param array $input
	 * @return bool True if validates
	 * @throws InvalidStructureException
	 */
	public function validate(array $input){
		$exception = new InvalidStructureException;

		// Validate given fields if types match
		foreach($input as $k => $v){
			try{
				$this->validateParam($k, $v);
			} catch(InvalidParameterTypeException $e){
				$exception->addBadField($k, $e->expectedItem);
			} catch(UnexpectedParameterException $e){
				$exception->addUnexpectedField($k);
			}
		}

		// Check for missing fields
		foreach($this->structure->getItems() as $k => $v){
			if(!array_key_exists($k, $input)){
				$exception->addMissingField($k, $v);
			}
		}

		if($exception->hasErrors()){
			throw $exception;
		}

		return true;
	}

	/**
	 * Check if a certain parameter is valid
	 * @param string $name
	 * @param mixed $value
	 * @throws InvalidParameterTypeException
	 * @throws InvalidStructureException
	 * @throws UnexpectedParameterException
	 */
	public function validateParam($name, $value){
		$item = $this->structure->getItemByName($name);

		if($item === null){
			throw new UnexpectedParameterException;
		}

		if($item instanceof Structure){
			// Recursive validation
			$validator = new self($item->structure);
			$validator->validate($value);
		} else{
			if(!$item->validate($value)){
				$e = new InvalidParameterTypeException;
				$e->expectedItem = $item;
				throw $e;
			}
		}
	}
}
