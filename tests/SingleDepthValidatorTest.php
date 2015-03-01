<?php


use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Briedis\ApiBuilder\Items\Float;
use Briedis\ApiBuilder\Items\Integer;
use Briedis\ApiBuilder\StructureBuilder;
use Briedis\ApiBuilder\StructureValidator;

class SingleDepthValidatorTest extends PHPUnit_Framework_TestCase{
	/** @var StructureBuilder */
	private $s;

	/** @var StructureValidator */
	private $v;

	protected function setUp(){
		$this->s = new StructureBuilder;
		$this->v = new StructureValidator($this->s);
	}

	public function testValidStructure(){
		$this->s
			->int('int')
			->string('string')
			->float('float')
			->boolean('bool');

		$input = [
			'int' => 123,
			'string' => 'String',
			'float' => (string)pi(),
			'bool' => 'true',
		];

		$this->assertTrue($this->v->validate($input), 'Structure is valid');
	}

	public function testMissingParam(){
		$this->s->int('int');
		$input = [];
		$caught = false;
		try{
			$this->v->validate($input);
		} catch(InvalidStructureException $e){
			$caught = true;
			$missing = $e->getMissingFields();
			$this->assertInstanceOf(Integer::class, $missing['int'], 'Correct field is missing');
			$this->assertEquals(1, count($missing), 'Missing parameter count matches');
		}

		$this->assertTrue($caught, 'Exception is caught');
	}

	public function testInvalidParam(){
		$this->s
			->int('id')
			->float('decimal')
			->int('validId');

		$input = [
			'id' => 'This is a string',
			'decimal' => true,
			'validId' => 123,
		];

		$caught = false;

		try{
			$this->v->validate($input);
		} catch(InvalidStructureException $e){
			$caught = true;
			$fields = $e->getBadFields();

			$this->assertInstanceOf(Integer::class, $fields['id'], 'Correct field is invalid');
			$this->assertInstanceOf(Float::class, $fields['decimal'], 'Correct field is invalid');
			$this->assertEquals(2, count($fields), 'Bad parameter count matches');
		}

		$this->assertTrue($caught, 'Exception is caught');
	}

	public function testUnexpectedParameter(){
		$this->s->int('id');

		$input = [
			'id' => 'This is a string',
			'key1' => 1,
			'key2' => 'something',
		];

		$caught = false;

		try{
			$this->v->validate($input);
		} catch(InvalidStructureException $e){
			$caught = true;
			$this->assertEquals(['key1', 'key2'], $e->getUnexpectedFields(), 'Unexpected fields match');
		}

		$this->assertTrue($caught, 'Exception is caught');
	}
}