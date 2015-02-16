<?php

/**
 * @var \Briedis\ApiBuilder\StructureBuilder $structureBuilder
 */

use Briedis\ApiBuilder\Items\Structure;

foreach($structureBuilder->getItems() as $v){
	?>
	<div class='item'>
		<div class='cols'>
			<div class="name">
				<?= $v->name; ?>
				<?php if(!$v->isOptional){ ?>
					<span class="required" title="Required">*</span>
				<?php } ?>
			</div>
			<div class="format"><?= $v->getDisplayTypeName(); ?></div>
			<div class="description"><?= $v->description; ?></div>
		</div>
	</div>
	<?php

	if($v instanceof Structure){
		?>
		<div class="sub">
			<?= View::make('api-builder::structure', ['structureBuilder' => $v->structure])->render(); ?>
		</div>
    <?php
	}
}