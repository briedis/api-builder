<?php


namespace Briedis\ApiBuilder\Items;


class Integer extends BaseItem{
	const TYPE = 'integer';

	public function validate($value){
		return (string)(int)$value === (string)$value;
	}
}