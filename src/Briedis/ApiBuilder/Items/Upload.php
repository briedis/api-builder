<?php


namespace Briedis\ApiBuilder\Items;


class Upload extends BaseItem{
	const TYPE = 'upload';

	public function validateValue($value){
		throw new \RuntimeException('Cannot validate a upload');
	}
}