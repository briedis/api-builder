<?php
namespace Briedis\ApiBuilder;


use Briedis\ApiBuilder\Items\BaseItem;
use Briedis\ApiBuilder\Items\Structure;

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
		$requestHtml = $this->getStructureTable($apiMethod->getRequest());

		$responseHtml = $this->getStructureTable($apiMethod->getResponse());

		$html = "
			<h1>{$this->translate($apiMethod->title)}</h1>
			<h2>URI</h2>
			{$apiMethod->uri}
			<h2>Method</h2>
			{$apiMethod->method}
			<h2>Description</h2>
			<p>{$this->translate($apiMethod->description)}</p>
			<h2>Request</h2>
			{$requestHtml}
			<h2>Response</h2>
			{$responseHtml}
		";

		return $html;
	}

	private function getStructureTable(StructureBuilder $structure){
		$table = "
			<table class='table' width='100%'>
				<thead>
					<tr>
						<th>Parameter</th>
						<th>Type</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					{$this->getStructureTableRows($structure)}
				</tbody>
			</table>
		";

		return $table;
	}

	/**
	 * @param StructureBuilder $structure
	 * @return string HTML
	 */
	private function getStructureTableRows(StructureBuilder $structure){
		$rows = '';
		foreach($structure->getItems() as $item){
			$required = $item->isOptional ? '' : '*';
			$rows .= "
					<tr>
						<td>{$item->name}{$required}</td>
						<td>{$this->getReadableItemType($item)}</td>
						<td>{$this->translate($item->description)}</td>
					</tr>
			";
			if($item instanceof Structure){
				$rows .= "
						<tr>
							<td colspan='3'>
								<table class='table-responsive' width='100%'>
									<tr>
										<td width='60'>&nbsp;</td>
										<td>{$this->getStructureTable($item->structure)}</td>
									</tr>
								</table>
							</td>
						<tr>
				";
			}
		}
		return $rows;
	}

	private function getReadableItemType(BaseItem $item){
		$type = $item::TYPE;

		if($item instanceof Structure){
			$type = $item->structure->getStructureName();
		}

		if($item->isArray){
			return $type . '[]';
		}

		if($item->isEnum){
			return '{' . implode(', ', $item->enumValues) . '}';
		}

		return $type;
	}

	/**
	 * Set a translation callback for method titles, descriptions, for parameter descriptions
	 * If no callback is set, no translations are made
	 * @param callable $callback
	 */
	public function setTranslateCallback(callable $callback){
		$this->callbackTranslate = $callback;
	}

	protected function translate($string){
		if(is_callable($this->callbackTranslate)){
			return call_user_func($this->callbackTranslate, $string);
		}
		return $string;
	}
}