<?php


namespace Briedis\ApiBuilder;


use Illuminate\Support\Str;

abstract class AbstractApiMethod{
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
	 * @return StructureBuilder
	 */
	abstract public function getRequest();

	/**
	 * Get structure(s) that will be returned by the request
	 * @return StructureBuilder
	 */
	abstract public function getResponse();

	/**
	 * Helper function for easier structure building
	 * @param string $structureName
	 * @return StructureBuilder
	 */
	protected function s($structureName = ''){
		return new StructureBuilder($structureName);
	}

	/**
	 * Get URL for this method within the documentation page
	 * @return string
	 */
	public function getDocUrl(){
		return '#' . $this->getDocElementName();
	}

	/**
	 * Get <a name=..> for documentation page element
	 * @return string
	 */
	public function getDocElementName(){
		return Str::slug(static::METHOD . '-' . static::URI);
	}
}