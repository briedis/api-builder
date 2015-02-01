<?php


use Briedis\ApiBuilder\AbstractApiMethod;
use Briedis\ApiBuilder\StructureBuilder;

class ExampleGetUserRequest extends AbstractApiMethod{
	public $uri = 'user/get';

	public $title = 'User information';

	public $description = 'Get user by given ids. One or multiple users can be fetched at once';

	public function getRequest(){
		return (new GetUsersStructure())->getStructure();
	}

	public function getResponse(){
		return (new StructureBuilder)
			->struct('users', new UserStructure(), 'Array with user objects')->multiple();
	}
}