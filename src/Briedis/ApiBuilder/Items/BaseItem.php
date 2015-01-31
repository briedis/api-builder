<?php


namespace Briedis\ApiBuilder\Items;


class BaseItem{
	const TYPE = 'mixed';

	public $name = '';

	public $description = '';

	public $isOptional = false;

	public $isArray = false;

	/**
	 * @var bool
	 */
	public $isEnum = false;

	/**
	 * @var array
	 */
	public $enumValues = [];

	public $parameters;

	public function __construct($name = '', $description = ''){
		$this->name = $name;
		$this->description = $description;
	}
}