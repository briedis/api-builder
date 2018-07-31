<?php

namespace Briedis\ApiBuilder\Tests;

use Mockery;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
}