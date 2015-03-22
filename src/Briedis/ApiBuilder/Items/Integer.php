<?php


namespace Briedis\ApiBuilder\Items;


class Integer extends BaseItem{
	const TYPE = 'integer';

	public function validateValue($value){
		return (string)(int)$value === (string)$value;
	}
}