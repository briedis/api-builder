<?php


namespace Briedis\ApiBuilder;


use Illuminate\Support\Str;

class MethodGroup{
	/**
	 * @var Method[]|MethodGroup[]
	 */
	private $items = [];

	/**
	 * @var string Title of the group
	 */
	private $title;

	public function __construct($title, array $items){
		$this->items = $items;
		$this->title = $title;
	}

	/**
	 * Get instance of MethodGroup
	 * @param string $groupTitle
	 * @param array $items
	 * @return MethodGroup
	 */
	public static function make($groupTitle, array $items){
		return new self($groupTitle, $items);
	}

	/**
	 * @return Method[]|MethodGroup[]
	 */
	public function getItems(){
		return $this->items;
	}

	/**
	 * @return string
	 */
	public function getTitle(){
		return $this->title;
	}

	/**
	 * Get URL for this group within the documentation page
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
		return Str::slug('group-' . $this->title);
	}
}