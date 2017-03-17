<?php

/**
 * @var \Briedis\ApiBuilder\MethodGroup $group
 * @var \Briedis\ApiBuilder\Presenter $presenter
 */
use Briedis\ApiBuilder\Presenter;

$groupId = htmlspecialchars(Presenter::getGroupDocElementName($group))

?>
    <h1 id="<?= $groupId; ?>"><?= $group->getTitle(); ?></h1>
<?php
foreach ($group->getItems() as $v) {
    echo Presenter::view('method', [
        'apiMethod' => $v,
        'presenter' => $presenter,
    ]);
}
