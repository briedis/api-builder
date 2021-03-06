<?php


namespace Briedis\ApiBuilder;


use Briedis\ApiBuilder\Items\BaseItem;
use Briedis\ApiBuilder\Items\BooleanItem;
use Briedis\ApiBuilder\Items\DecimalItem;
use Briedis\ApiBuilder\Items\IntegerItem;
use Briedis\ApiBuilder\Items\MixedItem;
use Briedis\ApiBuilder\Items\StringItem;
use Briedis\ApiBuilder\Items\StructureItem;
use Briedis\ApiBuilder\Items\UploadItem;

class StructureBuilder implements StructureInterface
{
    /**
     * @var string
     */
    private $structureName;

    /**
     * @var BaseItem[] [itemName => BaseItem, ..]
     */
    private $items = [];

    /**
     * @var BaseItem
     */
    private $lastItem;

    /**
     * Create a new structure
     * @param string $structureName
     */
    public function __construct($structureName = '')
    {
        $this->structureName = $structureName;
    }

    private function addItem(BaseItem $item)
    {
        $this->items[$item->name] = $item;
        $this->lastItem = $item;
        return $this;
    }

    public function getStructureName()
    {
        return $this->structureName;
    }

    /**
     * @return BaseItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Find an item by parameter name
     * @param $itemName
     * @return BaseItem|null
     */
    public function getItemByName($itemName)
    {
        return isset($this->items[$itemName]) ? $this->items[$itemName] : null;
    }

    /**
     * Integer type
     * @param string $name
     * @param string $description
     * @return StructureBuilder
     */
    public function int($name, $description = '')
    {
        return $this->addItem(new IntegerItem($name, $description));
    }

    /**
     * String type
     * @param string $name
     * @param string $description
     * @return StructureBuilder
     */
    public function str($name, $description = '')
    {
        return $this->addItem(new StringItem($name, $description));
    }

    /**
     * Float type
     * @param $name
     * @param string $description
     * @return StructureBuilder
     */
    public function float($name, $description = '')
    {
        return $this->addItem(new DecimalItem($name, $description));
    }

    /**
     * Boolean type
     * @param string $name
     * @param string $description
     * @return StructureBuilder
     */
    public function bool($name, $description = '')
    {
        return $this->addItem(new BooleanItem($name, $description));
    }

    /**
     * File upload type
     * @param string $name
     * @param string $description
     * @return StructureBuilder
     */
    public function upload($name, $description = '')
    {
        return $this->addItem(new UploadItem($name, $description));
    }

    /**
     * Mixed type. Can be anything
     * @param string $name
     * @param string $description
     * @return StructureBuilder
     */
    public function mixed($name, $description = '')
    {
        return $this->addItem(new MixedItem($name, $description));
    }

    /**
     * Set item as another structure
     * @param string $name
     * @param StructureInterface $structure
     * @param string $description
     * @return StructureBuilder
     */
    public function struct($name, StructureInterface $structure, $description = '')
    {
        $item = new StructureItem($name, $description);
        $item->structure = $structure->getStructure();
        return $this->addItem($item);
    }

    /**
     * Mark item as optional
     * @return self
     */
    public function optional()
    {
        $this->lastItem->isOptional = true;
        return $this;
    }

    /**
     * Mark item as enum and specify valid values
     * @param array $values
     * @return self
     */
    public function values(array $values)
    {
        if ($this->lastItem instanceof StructureItem || $this->lastItem instanceof BooleanItem) {
            throw new \InvalidArgumentException('Cannot mark this type as an enumerable');
        }
        $this->lastItem->isFixedValues = true;
        $this->lastItem->validValues = $values;
        return $this;
    }

    /**
     * Mark item as an array
     * @return self
     */
    public function multiple()
    {
        $this->lastItem->isArray = true;
        return $this;
    }

    /**
     * Get the structure object
     * @return self
     */
    public function getStructure()
    {
        return $this;
    }
}