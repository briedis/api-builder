<?php


namespace Briedis\ApiBuilder\Items;


class Boolean extends BaseItem{
	const TYPE = 'boolean';

	public function validate($value){
		return
			is_bool($value)
			|| $value === 'true'
			|| $value === 'false'
			|| (string)$value === '0'
			|| (string)$value === '1';
	}
}