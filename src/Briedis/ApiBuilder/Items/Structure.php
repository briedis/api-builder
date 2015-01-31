<?php


namespace Briedis\ApiBuilder\Items;


use Briedis\ApiBuilder\StructureBuilder;

class Structure extends BaseItem{
	const TYPE = 'structure';

	/** @var StructureBuilder */
	public $structure;
}