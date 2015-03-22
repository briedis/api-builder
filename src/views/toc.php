<?php
/**
 * @var MethodGroup[]|Method[] $items
 */

use Briedis\ApiBuilder\Method;
use Briedis\ApiBuilder\MethodGroup;


$outputMethod = function (Method $method){
	$url = htmlspecialchars($method->getDocUrl());
	return "<li><a href='{$url}'>{$method->title}</a></li>";
};

$outputArray = function (array $items) use (&$outputGroup, &$outputMethod){
	$html = '';

	foreach($items as $v){
		if($v instanceof MethodGroup){
			$html .= $outputGroup($v);
		}
		if($v instanceof Method){
			$html .= $outputMethod($v);
		}
	}

	return $html;
};

$outputGroup = function (MethodGroup $group) use (&$outputArray){
	$html = '
		<li>
			<a href="' . htmlspecialchars($group->getDocUrl()) . '"><b>' . $group->getTitle() . '</b></a>
			<ul>
			' . $outputArray($group->getItems()) . '
			</ul>
		</li>
	';
	return $html;
};


echo '<ul>' . $outputArray($items) . '</ul>';