<?php

namespace Briedis\ApiBuilder\Tests\Stubs;

use Briedis\ApiBuilder\Method;

class InvalidMethodStub extends Method
{
    const METHOD = 'UNKNOWN-METHOD';

    const URI = 'does-not-matter';

    public function getRequest()
    {
    }

    public function getResponse()
    {
    }

    public function validateResolved()
    {
    }
}