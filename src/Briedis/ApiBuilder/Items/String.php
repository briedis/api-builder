<?php


namespace Briedis\ApiBuilder\Items;


class String extends BaseItem{
	const TYPE = 'string';

	public function validate($value){
		return is_scalar($value) && !is_bool($value);
	}
}