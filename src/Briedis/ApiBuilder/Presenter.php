<?php
namespace Briedis\ApiBuilder;


use Illuminate\Support\Facades\View;

class Presenter{
	/**
	 * @var Method[]|MethodGroup[]
	 */
	private $methodsOrGroups;

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
	 * @param Method[]|MethodGroup[] $apiMethods
	 */
	public function __construct(array $apiMethods = []){
		$this->methodsOrGroups = $apiMethods;
	}

	/**
	 * @param Method|MethodGroup $methodOrGroup
	 * @return self
	 */
	public function add($methodOrGroup){
		$this->methodsOrGroups[] = $methodOrGroup;
		return $this;
	}

	public function render(){
		$methodHtml = '';

		foreach($this->methodsOrGroups as $v){
			$methodHtml .= $this->getMethodHtml($v);
		}

		$pageView = View::make('api-builder::page', [
			'methodHtml' => $methodHtml,
		]);

		return $pageView->render();
	}

	public function renderTOC(){
		return View::make('api-builder::toc', [
			'items' => $this->methodsOrGroups,
		])->render();
	}

	/**
	 * Output method or a group of methods
	 * @param Method|MethodGroup $methodOrGroup
	 * @return mixed
	 */
	private function getMethodHtml($methodOrGroup){
		if(!($methodOrGroup instanceof Method) && !($methodOrGroup instanceof MethodGroup)){
			throw new \InvalidArgumentException('Bad apiMethod type given');
		}

		if($methodOrGroup instanceof MethodGroup){
			return View::make('api-builder::group', [
				'group' => $methodOrGroup,
				'presenter' => $this,
			])->render();
		}

		return View::make('api-builder::method', [
			'apiMethod' => $methodOrGroup,
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