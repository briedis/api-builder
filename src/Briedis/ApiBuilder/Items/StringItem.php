<?php


namespace Briedis\ApiBuilder\Items;


class StringItem extends BaseItem{
	const TYPE = 'string';

	public function validateValue($value){
		return is_scalar($value) && !is_bool($value);
	}
}