<?php

namespace Briedis\ApiBuilder\Exceptions;

use Briedis\ApiBuilder\Items\BaseItem;

class InvalidParameterTypeException extends \Exception
{
    /** @var BaseItem */
    public $expectedItem;
}