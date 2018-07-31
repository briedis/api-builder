<?php

namespace Briedis\ApiBuilder\Tests\Unit;

use Briedis\ApiBuilder\Items\BaseItem;
use Briedis\ApiBuilder\Items\BooleanItem;
use Briedis\ApiBuilder\Items\DecimalItem;
use Briedis\ApiBuilder\Items\IntegerItem;
use Briedis\ApiBuilder\Items\MixedItem;
use Briedis\ApiBuilder\Items\StringItem;
use Briedis\ApiBuilder\Tests\TestCase;
use stdClass;

class TypeTest extends TestCase
{
    public function testInteger()
    {
        $this->itemAssertTrue([
            1,
            -100,
            0,
            '1',
            '1000',
        ], new IntegerItem);

    }

    public function testNotInteger()
    {
        $this->itemAssertFalse([
            1.1,
            ' ',
            'abc',
            '',
            '1 1',
            '3.22',
        ], new IntegerItem);
    }

    public function testIsBoolean()
    {
        $this->itemAssertTrue([
            true,
            false,
            'true',
            'false',
            '1',
            '0',
        ], new BooleanItem);
    }

    public function testIsNotBoolean()
    {
        $this->itemAssertFalse([
            'a',
            '123',
            '-1',
            '1a',
            null,
        ], new BooleanItem);
    }

    public function testIsFloat()
    {
        $this->itemAssertTrue([
            '0.1',
            '23345.233',
            '-1223',
            1.234,
            1e2,
        ], new DecimalItem);
    }

    public function testIsNotFloat()
    {
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
        ], new DecimalItem);
    }

    public function testIsString()
    {
        $this->itemAssertTrue([
            'a',
            'b',
            'some string',
            1234,
        ], new StringItem);
    }

    public function testIsNotString()
    {
        $this->itemAssertFalse([
            null,
            false,
            true,
            [],
            new stdClass,
        ], new StringItem);
    }

    public function testIsNotIntegerArray()
    {
        $item = new IntegerItem;
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

    public function testIsIntegerArray()
    {
        $item = new IntegerItem;
        $item->isArray = true;
        $this->itemAssertTrue([
            [],
            [1],
            [1, 2, 3, 4],
        ], $item);
    }

    public function testIsFixedValue()
    {
        $item = new IntegerItem;
        $item->isFixedValues = true;
        $item->validValues = [1, 2, 3];
        $this->itemAssertTrue([
            1,
            2,
            3,
        ], $item);

    }

    public function testIsNotFixedValue()
    {
        $item = new IntegerItem;
        $item->isFixedValues = true;
        $item->validValues = [1, 2, 3];
        $this->itemAssertFalse([
            0,
            4,
            5,
            6,
        ], $item);
    }

    public function testIsFixedValueArray()
    {
        $item = new IntegerItem;
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

    public function testIsNotFixedValueArray()
    {
        $item = new IntegerItem;
        $item->isFixedValues = true;
        $item->validValues = [1, 2, 3];
        $item->isArray = true;
        $this->itemAssertFalse([
            'a',
            ['a'],
            ['a', 1, 2],
            [1, 2, null],
            3,
        ], $item);
    }

    public function testIsStringFixedValues()
    {
        $item = new StringItem;
        $item->isFixedValues = true;
        $item->validValues = [1, 'a', 1.5];
        $this->itemAssertTrue([
            1,
            'a',
            1.5,
        ], $item);
    }

    public function testIsMixed()
    {
        $item = new MixedItem;
        $this->itemAssertTrue([
            1,
            'a',
            [123],
            1.434,
            true,
            null,
        ], $item);
    }

    private function itemAssertTrue(array $values, BaseItem $item)
    {
        foreach ($values as $v) {
            $this->assertTrue($item->validate($v),
                var_export($v, true) . ' should be of type ' . $item->getDisplayTypeName());
        }
    }

    private function itemAssertFalse(array $values, BaseItem $item)
    {
        foreach ($values as $v) {
            $this->assertFalse($item->validate($v),
                var_export($v, true) . ' should NOT be of type ' . $item->getDisplayTypeName());
        }
    }
}