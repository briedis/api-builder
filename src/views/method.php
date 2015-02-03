<?
/**
 * @var AbstractApiMethod $apiMethod
 * @var \Briedis\ApiBuilder\ApiPresenter $presenter
 */

use Briedis\ApiBuilder\AbstractApiMethod;

echo HTML::style('packages/briedis/api-builder/style.css');
echo HTML::script('packages/briedis/api-builder/script.js');

?>
<div class="api-builder">
	<a name="<?= $apiMethod::URI; ?>"></a>

	<div class="api-method">
		<h1><?= $apiMethod->title; ?></h1>

		<div class="call-url">
			<span class="method method-<?= strtolower($apiMethod::METHOD); ?>"><?= $apiMethod::METHOD; ?></span>
			<span class="domain"><?=$presenter->getDomain();?>/</span><span class="uri"><?= $apiMethod::URI; ?></span></div>

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
				<?= View::make('api-builder::structure', ['structureBuilder' => $apiMethod->getRequest()])->render(); ?>
			</div>
		</div>

		<div class="tab response hidden">
			<div class="param-block">
				<?= View::make('api-builder::structure', ['structureBuilder' => $apiMethod->getResponse()])->render(); ?>
			</div>
		</div>
	</div>
</div>