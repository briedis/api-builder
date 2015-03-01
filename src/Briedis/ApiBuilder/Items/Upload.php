<?php


namespace Briedis\ApiBuilder\Items;


class Upload extends BaseItem{
	const TYPE = 'upload';

	public function validate($value){
		throw new \RuntimeException('Cannot validate a upload');
	}
}