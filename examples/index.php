<?php
include __DIR__ . '/../vendor/autoload.php';

use Briedis\ApiBuilder\Presenter;

include __DIR__ . '/ExampleGetUserRequest.php';
include __DIR__ . '/Structures/response/LocationStructure.php';
include __DIR__ . '/Structures/response/UserStructure.php';
include __DIR__ . '/Structures/request/GetUsersStructure.php';

$presenter = new Presenter;

// Set a translation callback, if needed
$presenter->setTranslateCallback(function ($key) {
    return $key; // Call your trans() function
});

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