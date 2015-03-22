<?php


namespace Briedis\ApiBuilder\Items;


class String extends BaseItem{
	const TYPE = 'string';

	public function validateValue($value){
		return is_scalar($value) && !is_bool($value);
	}
}