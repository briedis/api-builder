<?php


namespace Briedis\ApiBuilder;


use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;

abstract class Method implements ValidatesWhenResolved
{
    /**
     * Requests uri (without trailing and preceding slashes)
     */
    const URI = '';

    /**
     * Requests method, GET, POST, .. (uppercase)
     */
    const METHOD = 'GET';

    /**
     * Descriptive title
     * @var string
     */
    public $title = '';

    /**
     * @var string
     */
    public $description = '';

    /**
     * Get structure(s) that will be passed to the request. Optional.
     * @return StructureInterface|null
     */
    abstract public function getRequest();

    /**
     * Get structure(s) that will be returned by the request
     * @return StructureInterface
     */
    abstract public function getResponse();

    /**
     * Helper function for easier structure building
     * @param string $structureName
     * @return StructureBuilder
     */
    protected function s($structureName = '')
    {
        return new StructureBuilder($structureName);
    }

    /**
     * Validate the given class instance.
     * @return void
     * @throws InvalidStructureException
     */
    public function validate()
    {
        $requestStructure = $this->getRequest();
        if (!$requestStructure) {
            return;
        }

        $validator = new StructureValidator($requestStructure);
        $validator->validate(\Request::input());
    }

    /**
     * Retrieve input field (or all)
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function input($key = null, $default = null)
    {
        return \Request::input($key, $default);
    }
}