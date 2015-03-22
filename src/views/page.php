<?php
/**
 * @var string $methodHtml Method contents
 */

use Briedis\ApiBuilder\Presenter;

?>
	<script src="<?= Presenter::resourceUrl('script.js'); ?>" type="text/javascript"></script>
	<link rel="stylesheet" href="<?= Presenter::resourceUrl('style.js'); ?>" property='stylesheet'>
<?php

echo $methodHtml;