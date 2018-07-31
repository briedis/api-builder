<?php

namespace Briedis\ApiBuilder\Tests\Stubs;

use Briedis\ApiBuilder\Method;

class PostMethodStub extends Method
{
    const METHOD = 'POST';

    const URI = 'post-uri';

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