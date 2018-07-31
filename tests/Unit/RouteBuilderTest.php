<?php

namespace Briedis\ApiBuilder\Tests\Unit;

use Briedis\ApiBuilder\RouteBuilder;
use Briedis\ApiBuilder\Tests\Stubs\GetMethodStub;
use Briedis\ApiBuilder\Tests\Stubs\InvalidMethodStub;
use Briedis\ApiBuilder\Tests\Stubs\PostMethodStub;
use Briedis\ApiBuilder\Tests\TestCase;
use Illuminate\Contracts\Routing\Registrar;
use Mockery;
use Mockery\Mock;
use Mockery\MockInterface;

class RouteBuilderTest extends TestCase
{
    /** @var Registrar|MockInterface|Mock */
    private $mock;

    /** @var RouteBuilder */
    private $builder;

    protected function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock(Registrar::class);
        $this->builder = new RouteBuilder($this->mock);
    }

    public function testGetMethod()
    {
        $method = new GetMethodStub;
        $this->mock->shouldReceive('get')->once();
        $result = $this->builder->add($method, 'action');

        self::assertInstanceOf(RouteBuilder::class, $result);
    }

    public function testPostMethod()
    {
        $method = new PostMethodStub;
        $this->mock->shouldReceive('post')->once();
        $result = $this->builder->add($method, 'controller@method');

        self::assertInstanceOf(RouteBuilder::class, $result);
    }

    public function testInvalidMethod()
    {
        $method = new InvalidMethodStub;
        self::expectException(\InvalidArgumentException::class);
        $this->builder->add($method, 'controller@method');
    }
}