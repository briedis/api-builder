<?php


use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Briedis\ApiBuilder\Items\Float;
use Briedis\ApiBuilder\StructureBuilder as SB;
use Briedis\ApiBuilder\StructureValidator;

class MultiDepthValidatorTest extends PHPUnit_Framework_TestCase{
	/** @var SB */
	private $s;

	/** @var StructureValidator */
	private $v;

	protected function setUp(){
		$this->s = new SB;
		$this->v = new StructureValidator($this->s);
	}

	public function testValidStructure(){
		$this->s
			->struct('s1', (new SB)
				->int('id')
			)->struct('s2', (new SB)
				->float('decimal')
			)->string('str');

		$input = [
			's1' => [
				'id' => 123,
			],
			's2' => [
				'decimal' => pi(),
			],
			'str' => 'Some string'
		];

		$this->assertTrue($this->v->validate($input), 'Structure is valid');
	}

	public function testInvalidStructure(){
		$caught = false;

		$this->s
			->struct('s', (new SB)
				->float('decimal')
			)
			->struct('s2', (new SB)
				->float('decimal')
			);

		$input = [
			's' => [
				'decimal' => 'not a decimal',
			],
			's2' => [
				'decimal' => 12345,
			]
		];

		try{
			$this->v->validate($input);
		} catch(InvalidStructureException $e){
			$caught = true;
			$fields = $e->getBadFields();
			$this->assertInstanceOf(get_class(new Float), $fields['decimal'], 'Correct field is missing');
			$this->assertEquals(1, count($fields), 'Bad parameter count matches');
		}

		$this->assertTrue($caught, 'Exception is caught');
	}

	public function testVeryDeepValidStructure(){
		$this->s
			->struct('s', (new SB)
				->struct('s', (new SB)
					->struct('s', (new SB)
						->struct('s', (new SB)
							->struct('s', (new SB)
								->int('id')
							)
						)
					)
				)
			);

		$input = [
			's' => [
				's' => [
					's' => [
						's' => [
							's' => [
								'id' => 123
							]
						]
					]
				]
			]
		];

		$this->assertTrue($this->v->validate($input), 'Valid deep structure');
	}
}