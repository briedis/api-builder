<?php

namespace Briedis\ApiBuilder\Tests\Stubs;

use Briedis\ApiBuilder\Method;

class GetMethodStub extends Method
{
    const METHOD = 'GET';

    const URI = 'get-uri';

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