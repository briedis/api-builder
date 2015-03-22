<?php

/**
 * @var \Briedis\ApiBuilder\MethodGroup $group
 * @var \Briedis\ApiBuilder\Presenter $presenter
 */
use Briedis\ApiBuilder\Presenter;

?>
	<h1 id="<?= htmlspecialchars($group->getDocElementName()); ?>"><?= $group->getTitle(); ?></h1>
<?php
foreach($group->getItems() as $v){
	echo Presenter::view('method', [
		'apiMethod' => $v,
		'presenter' => $presenter,
	]);
}
