<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Briedis\ApiBuilder\Tests\Unit;

use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Briedis\ApiBuilder\Items\DecimalItem;
use Briedis\ApiBuilder\Items\IntegerItem;
use Briedis\ApiBuilder\StructureBuilder;
use Briedis\ApiBuilder\StructureValidator;
use Briedis\ApiBuilder\Tests\TestCase;

class SingleDepthValidatorTest extends TestCase
{
    /** @var StructureBuilder */
    private $s;

    /** @var StructureValidator */
    private $v;

    protected function setUp(): void
    {
        parent::setUp();

        $this->s = new StructureBuilder;
        $this->v = new StructureValidator($this->s);
    }

    public function testValidStructure()
    {
        $this->s
            ->int('int')
            ->str('string')
            ->float('float')
            ->bool('bool');

        $input = [
            'int' => 123,
            'string' => 'String',
            'float' => (string)pi(),
            'bool' => 'true',
        ];

        $this->assertTrue($this->v->validate($input), 'Structure is valid');
    }

    public function testMissingParam()
    {
        $this->s->int('int');
        $input = [];
        $caught = false;
        try {
            $this->v->validate($input);
        } catch (InvalidStructureException $e) {
            $caught = true;
            $missing = $e->getMissingFields();
            $this->assertInstanceOf(get_class(new IntegerItem), $missing['int'], 'Correct field is missing');
            $this->assertEquals(1, count($missing), 'Missing parameter count matches');
        }

        $this->assertTrue($caught, 'Exception is caught');
    }

    public function testInvalidParam()
    {
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

        try {
            $this->v->validate($input);
        } catch (InvalidStructureException $e) {
            $caught = true;
            $fields = $e->getBadFields();

            $this->assertInstanceOf(get_class(new IntegerItem), $fields['id'], 'Correct field is invalid');
            $this->assertInstanceOf(get_class(new DecimalItem), $fields['decimal'], 'Correct field is invalid');
            $this->assertEquals(2, count($fields), 'Bad parameter count matches');
        }

        $this->assertTrue($caught, 'Exception is caught');
    }

    public function testUnexpectedParameter()
    {
        $this->s->int('id');

        $input = [
            'id' => 'This is a string',
            'key1' => 1,
            'key2' => 'something',
        ];

        $caught = false;

        try {
            $this->v->validate($input);
        } catch (InvalidStructureException $e) {
            $caught = true;
            $this->assertEquals(['key1', 'key2'], $e->getUnexpectedFields(), 'Unexpected fields match');
        }

        $this->assertTrue($caught, 'Exception is caught');
    }

    public function testOptionalParameterMissing()
    {
        $this->s->str('missing')->optional();
        $input = [];
        $this->assertTrue($this->v->validate($input), 'Optional parameter can be omitted');
    }

    public function testOptionalArrayParameterMissing()
    {
        $this->s->str('missing')->optional()->multiple();
        $input = [];
        $this->assertTrue($this->v->validate($input), 'Optional parameter can be omitted');
    }

    public function testOptionalArrayParameterAcceptsNull()
    {
        $this->s->str('missing')->multiple()->optional();
        $input = ['missing' => null];
        $this->assertTrue($this->v->validate($input), 'Optional parameter can be omitted');
    }

    public function testEmptyArrayIsValid()
    {
        $this->s->int('numbers')->multiple();
        $input = [
            'numbers' => [],
        ];
        $this->assertTrue($this->v->validate($input), 'Empty array is a valid type');
    }

    public function testOptionalWillAcceptNullValue()
    {
        $this->s->int('canBeNull')->optional();
        $input = [
            'canBeNull' => null,
        ];
        $this->assertTrue($this->v->validate($input), 'Optional parameter can be null');
    }
}