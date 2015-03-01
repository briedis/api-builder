<?php

use Briedis\ApiBuilder\Items\BaseItem;
use Briedis\ApiBuilder\Items\Boolean;
use Briedis\ApiBuilder\Items\Float;
use Briedis\ApiBuilder\Items\Integer;
use Briedis\ApiBuilder\Items\String;

class TypeTest extends PHPUnit_Framework_TestCase{
	public function testInteger(){
		$type = new Integer;

		$this->itemAssertTrue([
			1,
			-100,
			0,
			'1',
			'1000',
		], $type);

		$this->itemAssertFalse([
			1.1,
			' ',
			'abc',
			'',
			'1 1',
			'3.22',
		], $type);
	}

	public function testBoolean(){
		$type = new Boolean;

		$this->itemAssertTrue([
			true,
			false,
			'true',
			'false',
			'1',
			'0',
		], $type);

		$this->itemAssertFalse([
			'a',
			'123',
			'-1',
			'1a',
			null,
		], $type);
	}

	public function testFloat(){
		$type = new Float;

		$this->itemAssertTrue([
			'0.1',
			'23345.233',
			'-1223',
			1.234,
			1e2,
		], $type);

		$this->itemAssertFalse([
			'a',
			'1a',
			'a1',
		], $type);
	}

	public function testString(){
		$type = new String;

		$this->itemAssertTrue([
			'a',
			'b',
			'some string',
			1234
		], $type);

		$this->itemAssertFalse([
			null,
			false,
			true,
			[],
			new stdClass,
		], $type);
	}

	private function itemAssertTrue(array $values, BaseItem $item){
		foreach($values as $v){
			$this->assertTrue($item->validate($v), var_export($v, true) . ' is of type ' . $item->getDisplayTypeName());
		}
	}

	private function itemAssertFalse(array $values, BaseItem $item){
		foreach($values as $v){
			$this->assertFalse($item->validate($v), var_export($v, true) . ' is not of type ' . $item->getDisplayTypeName());
		}
	}
}