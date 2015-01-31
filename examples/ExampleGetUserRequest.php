<?php


use Briedis\ApiBuilder\AbstractApiMethod;
use Briedis\ApiBuilder\StructureBuilder;

class ExampleGetUserRequest extends AbstractApiMethod{
	public $uri = 'user/get';

	public $title = 'User information';

	public $description = 'Get user by given ids. One or multiple users can be fetched at once';

	public function getRequest(){
		return (new StructureBuilder)
			->int('userId', 'Array of user ids you want to fetch')->multiple()
			->int('offset', 'For paging purposes')->optional()
			->int('count', 'Amount of users to fetch. Defaults to 20')->optional();
	}

	public function getResponse(){
		$location = (new StructureBuilder('Location'))
			->float('lat', 'Latitude coordinate, in decimal format')
			->float('lon', 'Longitude coordinate, in decimal format');

		$user = (new StructureBuilder('User'))
			->int('id', 'Unique identifier')
			->string('username', 'Nickname that will be used in the system')
			->string('firstName', 'Users first name')
			->string('lastName', 'Users last name')
			->string('gender', 'M - male, F - female')->enum(['M', 'F'])->optional()
			->int('signature', 'Provide your favorite quote or something, if you want')->optional()
			->struct('location', $location, 'Location object for the user')->optional()
			->int('createdAt', 'Unix timestamp, when user has registered', '');

		$userList = (new StructureBuilder)
			->struct('users', $user, 'Array with user objects')->multiple();

		return $userList;
	}
}