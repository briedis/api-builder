<?php


namespace Briedis\ApiBuilder;

class MethodGroup
{
    /**
     * @var Method[]|MethodGroup[]
     */
    private $items = [];

    /**
     * @var string Title of the group
     */
    private $title;

    public function __construct($title, array $items)
    {
        $this->items = $items;
        $this->title = $title;
    }

    /**
     * Get instance of MethodGroup
     * @param string $groupTitle
     * @param array $items
     * @return MethodGroup
     */
    public static function make($groupTitle, array $items)
    {
        return new self($groupTitle, $items);
    }

    /**
     * @return Method[]|MethodGroup[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}