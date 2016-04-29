<?php


use Briedis\ApiBuilder\Method;
use Briedis\ApiBuilder\StructureBuilder;

class ExampleGetUserRequest extends Method
{
    const URI = 'user/get';

    const METHOD = 'GET';

    public $title = 'User information';

    public $description = 'Get user by given ids. One or multiple users can be fetched at once';

    public function getRequest()
    {
        return new GetUsersStructure;
    }

    public function getResponse()
    {
        return (new StructureBuilder)
            ->struct('users', new UserStructure, 'Array with user objects')->multiple();
    }
}