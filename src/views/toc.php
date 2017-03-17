<?php
/**
 * @var MethodGroup[]|Method[] $items
 */

use Briedis\ApiBuilder\Method;
use Briedis\ApiBuilder\MethodGroup;
use Briedis\ApiBuilder\Presenter;

$outputMethod = function (Method $method) {
    $url = htmlspecialchars(Presenter::getMethodDocUrl($method));
    return "<li><a href='{$url}'>{$method->title}</a></li>";
};

/**
 * @param MethodGroup[]|Method[] $items
 * @return string
 */
$outputArray = function (array $items) use (&$outputGroup, &$outputMethod) {
    $html = '';

    foreach ($items as $v) {
        if ($v instanceof MethodGroup) {
            $html .= $outputGroup($v);
        }
        if ($v instanceof Method) {
            $html .= $outputMethod($v);
        }
    }

    return $html;
};

$outputGroup = function (MethodGroup $group) use (&$outputArray) {
    $methodUrl = htmlspecialchars(Presenter::getGroupDocUrl($group));
    /** @noinspection PhpParamsInspection */
    return "
		<li>
			<a href='{$methodUrl}'><b>{$group->getTitle()}</b></a>
			<ul>{$outputArray($group->getItems())}</ul>
		</li>
	";
};


echo '<ul>' . $outputArray($items) . '</ul>';