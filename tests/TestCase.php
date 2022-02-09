<?php

namespace Briedis\ApiBuilder\Tests;

use Mockery;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}