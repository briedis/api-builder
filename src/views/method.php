<?php
/**
 * @var Method $apiMethod
 * @var Presenter $presenter
 */

use Briedis\ApiBuilder\Method;
use Briedis\ApiBuilder\Presenter;

?>
<div class="api-builder" id="<?= htmlspecialchars($apiMethod->getDocElementName()); ?>">

    <div class="api-method">
        <h1><?= $apiMethod->title; ?></h1>

        <div class="call-url">
            <span class="method method-<?= strtolower($apiMethod::METHOD); ?>"><?= $apiMethod::METHOD; ?></span>
            <span class="domain"><?= $presenter->getDomain(); ?>/</span><span class="uri"><?= $apiMethod::URI; ?></span>
        </div>

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="javascript:" data-target="description">Description</a>
            </li>
            <li>
                <a href="javascript:" data-target="parameters">Parameters</a>
            </li>
            <li>
                <a href="javascript:" data-target="response">Response</a>
            </li>
        </ul>

        <div class="tab description"><?= $apiMethod->description; ?></div>

        <div class="tab parameters hidden">
            <div class="param-block">
                <?= Presenter::view('structure', ['structure' => $apiMethod->getRequest()]); ?>
            </div>
        </div>

        <div class="tab response hidden">
            <div class="param-block">
                <?= Presenter::view('structure', ['structure' => $apiMethod->getResponse()]); ?>
            </div>
        </div>
    </div>
</div>