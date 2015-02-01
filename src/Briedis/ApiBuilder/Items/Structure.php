<?php


namespace Briedis\ApiBuilder\Items;


use Briedis\ApiBuilder\StructureBuilder;

class Structure extends BaseItem{
	/** @var StructureBuilder */
	public $structure;

	public function getTypeName(){
		return $this->structure->getStructureName();
	}
}