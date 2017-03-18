<?php


namespace Briedis\ApiBuilder\Exceptions;


class InvalidResponseStructureException extends InvalidStructureException
{
    /**
     * @var string
     */
    protected $message = 'Invalid response structure';
}