<?php
/**
 * @var MethodGroup[]|AbstractApiMethod[] $items
 */

use Briedis\ApiBuilder\AbstractApiMethod;
use Briedis\ApiBuilder\MethodGroup;


$outputMethod = function (AbstractApiMethod $method){
	$html = '
		<li>
			<a href="' . htmlspecialchars($method->getDocUrl()) . '">' . $method->title . '</a>
		</li>
	';

	return $html;
};

$outputArray = function (array $items) use (&$outputGroup, &$outputMethod){
	$html = '';

	foreach($items as $v){
		if($v instanceof MethodGroup){
			$html .= $outputGroup($v);
		}
		if($v instanceof AbstractApiMethod){
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