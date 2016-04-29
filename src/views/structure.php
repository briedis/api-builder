<?php

/**
 * @var \Briedis\ApiBuilder\StructureInterface $structure
 */

use Briedis\ApiBuilder\Items\StructureItem;
use Briedis\ApiBuilder\Presenter;

$items = $structure->getStructure()->getItems();

foreach ($items as $v) {
    ?>
    <div class='item'>
        <div class='cols'>
            <div class="name">
                <?= $v->name; ?>
                <?php if (!$v->isOptional) { ?>
                    <span class="required" title="Required">*</span>
                <?php } ?>
            </div>
            <div class="format"><?= $v->getDisplayTypeName(); ?></div>
            <div class="description"><?= $v->description; ?></div>
        </div>
    </div>
    <?php

    if ($v instanceof StructureItem) {
        ?>
        <div class="sub">
            <?= Presenter::view('structure', ['structure' => $v->structure]); ?>
        </div>
        <?php
    }
}