<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Briedis\ApiBuilder\Tests\Unit;

use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Briedis\ApiBuilder\Items\DecimalItem;
use Briedis\ApiBuilder\StructureBuilder;
use Briedis\ApiBuilder\StructureValidator;
use Briedis\ApiBuilder\Tests\TestCase;

class MultiDepthValidatorTest extends TestCase
{
    /** @var StructureBuilder */
    private $s;

    /** @var StructureValidator */
    private $v;

    protected function setUp()
    {
        parent::setUp();

        $this->s = new StructureBuilder;
        $this->v = new StructureValidator($this->s);
    }

    public function testValidStructure()
    {
        $this->s
            ->struct('s1', (new StructureBuilder)
                ->int('id')
            )->struct('s2', (new StructureBuilder)
                ->float('decimal')
            )->str('str');

        $input = [
            's1' => [
                'id' => 123,
            ],
            's2' => [
                'decimal' => pi(),
            ],
            'str' => 'Some string',
        ];

        $this->assertTrue($this->v->validate($input), 'Structure is valid');
    }

    public function testInvalidStructure()
    {
        $caught = false;

        $this->s
            ->struct('s11', (new StructureBuilder)
                ->float('decimal')
            )
            ->struct('s22', (new StructureBuilder)
                ->float('decimal')
            );

        $input = [
            's11' => [
                'decimal' => 'not a decimal',
            ],
            's22' => [
                'decimal' => 12345,
            ],
        ];

        try {
            $this->v->validate($input);
        } catch (InvalidStructureException $e) {
            $caught = true;
            $fields = $e->getBadFields();
            $this->assertInstanceOf(get_class(new DecimalItem), $fields['s11.decimal'], 'Correct field is missing');
            $this->assertEquals(1, count($fields), 'Bad parameter count matches');
        }

        $this->assertTrue($caught, 'Exception is caught');
    }

    public function testVeryDeepValidStructure()
    {
        $this->s
            ->struct('s111', (new StructureBuilder)
                ->struct('s222', (new StructureBuilder)
                    ->struct('s333', (new StructureBuilder)
                        ->struct('s444', (new StructureBuilder)
                            ->struct('s555', (new StructureBuilder)
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
                                'id' => 123,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertTrue($this->v->validate($input), 'Valid deep structure');
    }


    public function testWrongParameterDepth()
    {
        $this->s
            ->str('1_1')
            ->struct('1_3', (new StructureBuilder)
                ->str('2_1')
                ->struct('2_2', (new StructureBuilder)
                    ->str('3_1')
                    ->struct('3_2', (new StructureBuilder)
                        ->struct('4_1', (new StructureBuilder)
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


        try {
            $this->v->validate($input);
        } catch (InvalidStructureException $e) {
            $badFields = $e->getBadFields();
        }

        foreach ($badPaths as $v) {
            $this->assertTrue(isset($badFields[$v]), 'Field [' . $v . '] should be missing');
        }
    }

    public function testValidArrayOfStructures()
    {
        $item = (new StructureBuilder('MyStructure'))
            ->int('id')
            ->str('name')
            ->str('status')->values(['one', 'two', 'three'])->optional();

        $whole = (new StructureBuilder)
            ->int('someId')
            ->struct('items', $item)->multiple();

        $structureValidator = new StructureValidator($whole);

        $result = $structureValidator->validate([
            'someId' => 666,
            'items' => [
                [
                    'id' => 1,
                    'name' => 'string',
                    'status' => 'one',
                ],
                [
                    'id' => 2,
                    'name' => 'string',
                    'status' => 'two',
                ],
                [
                    'id' => 3,
                    'name' => 'string',
                ],
            ],
        ]);

        self::assertTrue($result);
    }

    public function testInvalidArrayOfStructures()
    {
        $item = (new StructureBuilder('MyStructure'))
            ->int('id')
            ->str('name');

        $whole = (new StructureBuilder)->struct('items', $item)->multiple();

        $structureValidator = new StructureValidator($whole);


        try {
            $structureValidator->validate([
                'items' => [
                    [
                        'id' => 1,
                        'unexpectedNested' => true,
                    ],
                ],
            ]);
        } catch (InvalidStructureException $e) {
            self::assertTrue(array_key_exists('items.name', $e->getMissingFields()));
            self::assertTrue(in_array('items.unexpectedNested', $e->getUnexpectedFields()));
            return;
        }

        self::assertFalse(true, 'This should not execute');
    }

    public function testStructureOfArrayReceivesInvalidStructure()
    {
        $item = (new StructureBuilder('MyStructure'))
            ->int('id')
            ->str('name');

        $whole = (new StructureBuilder)->struct('items', $item)->multiple();

        $structureValidator = new StructureValidator($whole);

        try {
            $structureValidator->validate([
                'items' => [
                    'invalidDirectArray' => 'value',
                ],
            ]);
        } catch (InvalidStructureException $e) {
            self::assertTrue(array_key_exists('items', $e->getBadFields()));
            return;
        }

        self::assertFalse(true, 'This should not execute');
    }

    public function testOptionalStructuresCanBeNull()
    {
        $item = (new StructureBuilder('MyStructure'));

        $whole = (new StructureBuilder)->struct('item', $item)->optional();

        $structureValidator = new StructureValidator($whole);

        self::assertTrue($structureValidator->validate(['item' => null]));
    }
}