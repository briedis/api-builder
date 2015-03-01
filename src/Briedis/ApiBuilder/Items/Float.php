<?php


namespace Briedis\ApiBuilder\Items;


class Float extends BaseItem{
	const TYPE = 'float';

	public function validate($value){
		return is_numeric($value) && (string)$value === (string)(float)$value;
	}
}