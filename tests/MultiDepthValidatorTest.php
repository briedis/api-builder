<?php


use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Briedis\ApiBuilder\Items\Decimal;
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
			)->str('str');

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
			->struct('s11', (new SB)
				->float('decimal')
			)
			->struct('s22', (new SB)
				->float('decimal')
			);

		$input = [
			's11' => [
				'decimal' => 'not a decimal',
			],
			's22' => [
				'decimal' => 12345,
			]
		];

		try{
			$this->v->validate($input);
		} catch(InvalidStructureException $e){
			$caught = true;
			$fields = $e->getBadFields();
			$this->assertInstanceOf(get_class(new Decimal), $fields['s11.decimal'], 'Correct field is missing');
			$this->assertEquals(1, count($fields), 'Bad parameter count matches');
		}

		$this->assertTrue($caught, 'Exception is caught');
	}

	public function testVeryDeepValidStructure(){
		$this->s
			->struct('s111', (new SB)
				->struct('s222', (new SB)
					->struct('s333', (new SB)
						->struct('s444', (new SB)
							->struct('s555', (new SB)
								->int('id')
							)
						)
					)
				)
			);

		$input = [
			's111' => [
				's222' => [
					's333' => [
						's444' => [
							's555' => [
								'id' => 123
							]
						]
					]
				]
			]
		];

		$this->assertTrue($this->v->validate($input), 'Valid deep structure');
	}


	public function testWrongParameterDepth(){
		$this->s
			->str('1_1')
			->struct('1_3', (new SB)
				->str('2_1')
				->struct('2_2', (new SB)
					->str('3_1')
					->struct('3_2', (new SB)
						->struct('4_1', (new SB)
							->bool('5_1')
							->int('5_2')
						)
					)
				)
			);

		$input = [
			'1_3' => [
				'2_2' => [
					'3_2' => [
						'4_1' => [
							'5_1' => 'Not boolean',
							'5_2' => 'Not integer',
						],
					],
				],
			],
		];

		$badPaths = [
			'1_3.2_2.3_2.4_1.5_1',
			'1_3.2_2.3_2.4_1.5_2',
		];

		$badFields = [];


		try{
			$this->v->validate($input);
		} catch(InvalidStructureException $e){
			$badFields = $e->getBadFields();
		}

		foreach($badPaths as $v){
			$this->assertTrue(isset($badFields[$v]), 'Field [' . $v . '] should be missing');
		}
	}
}