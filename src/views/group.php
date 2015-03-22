<?php

/**
 * @var \Briedis\ApiBuilder\MethodGroup $group
 * @var \Briedis\ApiBuilder\Presenter $presenter
 */

?>
	<h1 id="<?= htmlspecialchars($group->getDocElementName()); ?>"><?= $group->getTitle(); ?></h1>
<?php
foreach($group->getItems() as $v){
	echo View::make('api-builder::method', [
		'apiMethod' => $v,
		'presenter' => $presenter,
	])->render();
}
