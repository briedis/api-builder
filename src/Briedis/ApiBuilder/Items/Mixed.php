<?php


namespace Briedis\ApiBuilder\Items;


class Mixed extends BaseItem{
	const TYPE = 'mixed';

	protected function validateValue($value){
		// All values are valid mixed values
		return true;
	}
}