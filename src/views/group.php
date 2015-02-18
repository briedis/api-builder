<?php

/**
 * @var \Briedis\ApiBuilder\MethodGroup $group
 * @var \Briedis\ApiBuilder\ApiPresenter $presenter
 */

?>
	<a name="<?= htmlspecialchars($group->getDocElementName()); ?>"></a>
	<h1><?= $group->getTitle(); ?></h1>
<?php
foreach($group->getItems() as $v){
	echo View::make('api-builder::method', [
		'apiMethod' => $v,
		'presenter' => $presenter,
	])->render();
}
