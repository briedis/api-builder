<?php

use Briedis\ApiBuilder\ApiPresenter;

include __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/ExampleGetUserRequest.php';

$presenter = new ApiPresenter;
$presenter->add(new ExampleGetUserRequest);

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
</head>
<body>
<div class="container">
	<?= $presenter->render(); ?>
</div>
</body>
</html>