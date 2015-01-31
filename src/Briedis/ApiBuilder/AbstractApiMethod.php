<?php


namespace Briedis\ApiBuilder;


abstract class AbstractApiMethod{
	/**
	 * Requests uri
	 * @var string
	 */
	public $uri = '';

	/**
	 * Requests method
	 * @var string
	 */
	public $method = 'GET';

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
}