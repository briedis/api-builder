# api-builder for Laravel

[![Build passes?](https://travis-ci.org/briedis/api-builder.svg)](https://travis-ci.org/briedis/api-builder)
[![Latest Stable Version](https://poser.pugx.org/briedis/api-builder/v/stable.svg)](https://packagist.org/packages/briedis/api-builder)
[![Latest Unstable Version](https://poser.pugx.org/briedis/api-builder/v/unstable.svg)](https://packagist.org/packages/briedis/api-builder)


Library helps you build a documentation for your api, and you can even use it to validate request parameters

## Usage
### Laravel 4
1. Add composer dependency `"briedis/api-builder": "~1.0"` and run `composer update`
2. Add service provider `Briedis\ApiBuilder\ApiBuilderLaravel4ServiceProvider`
3. Publish assets public directory: `php artisan asset:publish briedis/api-builder`

### Laravel 5
1. Add composer dependency `"briedis/api-builder": "~1.0"` and run `composer update`
2. Add service provider `Briedis\ApiBuilder\ApiBuilderLaravel5ServiceProvider`
3. Publish assets to public directory: `php artisan vendor:publish --force --provider="Briedis\ApiBuilder\ApiBuilderLaravel5ServiceProvider"` (force means that existing files will be overwritten) 

## Request class
```php
use Briedis\ApiBuilder\AbstractApiMethod;
use Briedis\ApiBuilder\StructureBuilder;

class ExampleGetUserRequest extends AbstractApiMethod{
	const URI = 'user/get';

	const METHOD = 'GET';

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
```

## Structure class
```php
use Briedis\ApiBuilder\StructureBuilder;

class GetUsersStructure implements \Briedis\ApiBuilder\ApiStructureInterface {
	public function getStructure(){
		return (new StructureBuilder)
			->int('userId', 'Array of user ids you want to fetch')->multiple()
			->int('offset', 'For paging purposes')->optional()
			->int('count', 'Amount of users to fetch. Defaults to 20')->optional();
	}
}

class UserStructure implements ApiStructureInterface{
	public function getStructure(){
		return (new StructureBuilder('User'))
			->int('id', 'Unique identifier')
			->string('username', 'Nickname that will be used in the system')
			->string('firstName', 'Users first name')
			->string('lastName', 'Users last name')
			->string('gender', 'M - male, F - female')->enum(['M', 'F'])->optional()
			->int('signature', 'Provide your favorite quote or something, if you want')->optional()
			->struct('location', new LocationStructure, 'Location object for the user')->optional()
			->int('createdAt', 'Unix timestamp, when user has registered', '');
	}
}
```

## Outputting
```php
$presenter = new \Briedis\ApiBuilder\ApiPresenter([
	new Requests\UsersRequest,
	new Requests\ConversationsRequest,
	new Requests\ConversationReplyRequest,
]);

$presenter->setDomain('http://example/api/v1'));

echo $presenter->render();
```


## TODO
*  Automatic route generating
