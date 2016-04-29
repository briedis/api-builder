<?php


namespace Briedis\ApiBuilder\Items;


class DecimalItem extends BaseItem{
	const TYPE = 'float';

	public function validateValue($value){
		return is_numeric($value) && (string)$value === (string)(float)$value;
	}
}