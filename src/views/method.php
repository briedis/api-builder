<?php
/**
 * @var Method $apiMethod
 * @var Presenter $presenter
 */

use Briedis\ApiBuilder\Method;
use Briedis\ApiBuilder\Presenter;

$request = $apiMethod->getRequest();

$methodId = htmlspecialchars(Presenter::getMethodDocElementName($apiMethod));

$methodUri = '/' . ltrim($apiMethod::URI, '/');

?>
<div class="api-builder" id="<?= $methodId; ?>">

    <div class="api-method">
        <h1><?= $apiMethod->title; ?></h1>

        <div class="call-url">
            <span class="method method-<?= strtolower($apiMethod::METHOD); ?>"><?= $apiMethod::METHOD; ?></span>
            <span class="domain"><?= $presenter->getDomain(); ?></span><span class="uri"><?= $methodUri; ?></span>
        </div>

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="javascript:" data-target="description" onclick="apiBuilderTabClick(this);">Description</a>
            </li>
            <?php if ($request && $request->getStructure()->getItems()) { ?>
                <li>
                    <a href="javascript:" onclick="apiBuilderTabClick(this);" data-target="parameters">Parameters</a>
                </li>
            <?php } ?>
            <li>
                <a href="javascript:" data-target="response" onclick="apiBuilderTabClick(this);">Response</a>
            </li>
        </ul>

        <div class="tab description"><?= $apiMethod->description; ?></div>

        <div class="tab parameters hidden">
            <div class="param-block">
                <?= Presenter::view('structure', ['structure' => $request]); ?>
            </div>
        </div>

        <div class="tab response hidden">
            <div class="param-block">
                <?= Presenter::view('structure', ['structure' => $apiMethod->getResponse()]); ?>
            </div>
        </div>
    </div>
</div>