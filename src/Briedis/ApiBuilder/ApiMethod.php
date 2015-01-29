<?php


namespace Briedis\ApiBuilder;


class ApiMethod{
	/**
	 * Method of this request
	 * @var string
	 */
	protected $method;

	/**
	 * API method uri
	 * @var
	 */
	protected $uri;

	/**
	 * Structure(s) that are in a request
	 * @var StructureBuilder[]
	 */
	private $requestParams = [];

	/**
	 * Response structure(s)
	 * @var StructureBuilder[]
	 */
	private $responseParams = [];

	public function __construct($uri, $method = 'GET'){
		$this->uri = $uri;
		$this->method = $method;
	}

	/**
	 * Add structure that will be passed to the request
	 * @param StructureBuilder $structure
	 * @return $this
	 */
	public function addRequest(StructureBuilder $structure){
		$this->requestParams[] = $structure;
		return $this;
	}

	/**
	 * Add structure that will be returned from the request
	 * @param StructureBuilder $structure
	 * @return $this
	 */
	public function addResponse(StructureBuilder $structure){
		$this->responseParams[] = $structure;
		return $this;
	}
}