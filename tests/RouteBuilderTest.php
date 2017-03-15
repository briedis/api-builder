<?php

namespace Briedis\ApiBuilder\Tests;

use Briedis\ApiBuilder\RouteBuilder;
use Briedis\ApiBuilder\Tests\Stubs\GetMethodStub;
use Briedis\ApiBuilder\Tests\Stubs\InvalidMethodStub;
use Briedis\ApiBuilder\Tests\Stubs\PostMethodStub;
use Illuminate\Contracts\Routing\Registrar;
use Mockery;
use Mockery\Mock;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;

class RouteBuilderTest extends PHPUnit_Framework_TestCase
{
    /** @var Registrar|MockInterface|Mock */
    private $mock;

    /** @var RouteBuilder */
    private $builder;


    public static function tearDownAfterClass()
    {
        Mockery::close();
        parent::tearDownAfterClass();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->mock = Mockery::mock(Registrar::class);
        $this->builder = new RouteBuilder($this->mock);
    }

    public function testGetMethod()
    {
        $method = new GetMethodStub;
        $this->mock->shouldReceive('get')->with($method::URI, 'action')->once();
        $this->builder->add($method, 'action');
    }

    public function testPostMethod()
    {
        $method = new PostMethodStub;
        $this->mock->shouldReceive('post')->with($method::URI, 'controller@method')->once();
        $this->builder->add($method, 'controller@method');
    }

    public function testInvalidMethod()
    {
        $method = new InvalidMethodStub;
        self::setExpectedException(\InvalidArgumentException::class);
        $this->builder->add($method, 'controller@method');
    }
}