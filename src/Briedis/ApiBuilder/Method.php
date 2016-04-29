<?php


namespace Briedis\ApiBuilder;


use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\Str;
use Input;

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
     * Get structure(s) that will be passed to the request
     * @return StructureInterface
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
     * Get URL for this method within the documentation page
     * @return string
     */
    public function getDocUrl()
    {
        return '#' . $this->getDocElementName();
    }

    /**
     * Get <a name=..> for documentation page element
     * @return string
     */
    public function getDocElementName()
    {
        return Str::slug(static::METHOD . '-' . static::URI);
    }

    /**
     * Validate the given class instance.
     * @return void
     * @throws InvalidStructureException
     */
    public function validate()
    {
        $validator = new StructureValidator($this->getRequest());
        $validator->validate(Input::all());
    }
}