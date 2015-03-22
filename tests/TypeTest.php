<?php

use Briedis\ApiBuilder\Items\BaseItem;
use Briedis\ApiBuilder\Items\Boolean;
use Briedis\ApiBuilder\Items\Float;
use Briedis\ApiBuilder\Items\Integer;
use Briedis\ApiBuilder\Items\String;

class TypeTest extends PHPUnit_Framework_TestCase{
	public function testInteger(){
		$this->itemAssertTrue([
			1,
			-100,
			0,
			'1',
			'1000',
		], new Integer);

	}

	public function testNotInteger(){
		$this->itemAssertFalse([
			1.1,
			' ',
			'abc',
			'',
			'1 1',
			'3.22',
		], new Integer);
	}

	public function testIsBoolean(){
		$this->itemAssertTrue([
			true,
			false,
			'true',
			'false',
			'1',
			'0',
		], new Boolean);
	}

	public function testIsNotBoolean(){
		$this->itemAssertFalse([
			'a',
			'123',
			'-1',
			'1a',
			null,
		], new Boolean);
	}

	public function testIsFloat(){
		$this->itemAssertTrue([
			'0.1',
			'23345.233',
			'-1223',
			1.234,
			1e2,
		], new Float);
	}

	public function testIsNotFloat(){
		$this->itemAssertFalse([
			'a',
			'1a',
			'a1',
			null,
			false,
			true,
			'0xf4c3b00c',
			'0b10100111001',
			'0777',
		], new Float);
	}

	public function testIsString(){
		$this->itemAssertTrue([
			'a',
			'b',
			'some string',
			1234
		], new String);
	}

	public function testIsNotString(){
		$this->itemAssertFalse([
			null,
			false,
			true,
			[],
			new stdClass,
		], new String);
	}

	public function testIsNotIntegerArray(){
		$item = new Integer;
		$item->isArray = true;
		$this->itemAssertFalse([
			1,
			'a',
			['a'],
			[123.45],
			-123,
			['a', 1],
		], $item);
	}

	public function testIsIntegerArray(){
		$item = new Integer;
		$item->isArray = true;
		$this->itemAssertTrue([
			[],
			[1],
			[1, 2, 3, 4],
		], $item);
	}

	public function testIsFixedValue(){
		$item = new Integer;
		$item->isFixedValues = true;
		$item->validValues = [1, 2, 3];
		$this->itemAssertTrue([
			1,
			2,
			3,
		], $item);

	}

	public function testIsNotFixedValue(){
		$item = new Integer;
		$item->isFixedValues = true;
		$item->validValues = [1, 2, 3];
		$this->itemAssertFalse([
			0,
			4,
			5,
			6,
		], $item);
	}

	public function testIsFixedValueArray(){
		$item = new Integer;
		$item->isFixedValues = true;
		$item->validValues = [1, 2, 3];
		$item->isArray = true;
		$this->itemAssertTrue([
			[],
			[1],
			[1, 2],
			[1, 2, 3],
		], $item);
	}

	public function testIsNotFixedValueArray(){
		$item = new Integer;
		$item->isFixedValues = true;
		$item->validValues = [1, 2, 3];
		$item->isArray = true;
		$this->itemAssertFalse([
			'a',
			['a'],
			['a', 1, 2],
			[1, 2, null],
			3
		], $item);
	}

	public function testIsMixedFixedValues(){
		$item = new String;
		$item->isFixedValues = true;
		$item->validValues = [1, 'a', 1.5];
		$this->itemAssertTrue([
			1,
			'a',
			1.5,
		], $item);
	}

	private function itemAssertTrue(array $values, BaseItem $item){
		foreach($values as $v){
			$this->assertTrue($item->validate($v), var_export($v, true) . ' should be of type ' . $item->getDisplayTypeName());
		}
	}

	private function itemAssertFalse(array $values, BaseItem $item){
		foreach($values as $v){
			$this->assertFalse($item->validate($v), var_export($v, true) . ' should NOT be of type ' . $item->getDisplayTypeName());
		}
	}
}