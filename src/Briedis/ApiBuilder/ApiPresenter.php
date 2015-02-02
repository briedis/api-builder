<?php
namespace Briedis\ApiBuilder;


use View;

class ApiPresenter{
	/**
	 * @var AbstractApiMethod[]
	 */
	private $apiMethods;

	/**
	 * Callable for translating title and description
	 * @var callable (string $string)
	 */
	private $callbackTranslate;

	/**
	 * API domain WITHOUT trailing slash
	 * @var string
	 */
	private $domain;

	/**
	 * Initialize presenter with api methods
	 * @param AbstractApiMethod[] $apiMethods
	 */
	public function __construct(array $apiMethods = []){
		$this->apiMethods = $apiMethods;
	}

	/**
	 * @param AbstractApiMethod $apiMethod
	 * @return self
	 */
	public function add(AbstractApiMethod $apiMethod){
		$this->apiMethods[] = $apiMethod;
		return $this;
	}

	public function render(){
		$html = '';
		foreach($this->apiMethods as $v){
			$html .= $this->getHtml($v);
		}
		return $html;
	}

	private function getHtml(AbstractApiMethod $apiMethod){
		return View::make('api-builder::method', [
			'apiMethod' => $apiMethod,
			'presenter' => $this,
		])->render();
	}

	/**
	 * Set a translation callback for method titles, descriptions, for parameter descriptions
	 * If no callback is set, no translations are made
	 * @param callable $callback
	 */
	public function setTranslateCallback(callable $callback){
		$this->callbackTranslate = $callback;
	}

	public function translate($string){
		if(is_callable($this->callbackTranslate)){
			return call_user_func($this->callbackTranslate, $string);
		}
		return $string;
	}

	/**
	 * Set API domain
	 * @param string $domain
	 * @return self
	 */
	public function setDomain($domain){
		$this->domain = $domain;
		return $this;
	}

	/**
	 * Get API domain
	 * @return string
	 */
	public function getDomain(){
		return $this->domain;
	}
}