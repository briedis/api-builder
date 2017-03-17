<?php

namespace Briedis\ApiBuilder;


use Illuminate\Support\Str;

class Presenter
{
    const VIEW_NAMESPACE = 'api-builder';

    /**
     * @var Method[]|MethodGroup[]
     */
    private $methodsOrGroups;

    /**
     * Callable for translating title and description
     * @var callable (string $string)
     */
    private $callbackTranslate;

    /**
     * API domain (https://domain/ or  https://domain/api/v1/, etc.)
     * @var string
     */
    private $domain;

    /**
     * Initialize presenter with api methods
     * @param Method[]|MethodGroup[] $apiMethods
     */
    public function __construct(array $apiMethods = [])
    {
        $this->methodsOrGroups = $apiMethods;
    }

    /**
     * @param Method|MethodGroup $methodOrGroup
     * @return self
     */
    public function add($methodOrGroup)
    {
        $this->methodsOrGroups[] = $methodOrGroup;
        return $this;
    }

    public function render()
    {
        $methodHtml = '';

        foreach ($this->methodsOrGroups as $v) {
            $methodHtml .= $this->getMethodHtml($v);
        }

        return self::view('page', [
            'methodHtml' => $methodHtml,
        ]);
    }

    public function renderTOC()
    {
        return self::view('toc', [
            'items' => $this->methodsOrGroups,
        ]);
    }

    /**
     * Output method or a group of methods
     * @param Method|MethodGroup $methodOrGroup
     * @return mixed
     */
    private function getMethodHtml($methodOrGroup)
    {
        if (!($methodOrGroup instanceof Method) && !($methodOrGroup instanceof MethodGroup)) {
            throw new \InvalidArgumentException('Bad apiMethod type given');
        }

        if ($methodOrGroup instanceof MethodGroup) {
            return self::view('group', [
                'group' => $methodOrGroup,
                'presenter' => $this,
            ]);
        }

        return self::view('method', [
            'apiMethod' => $methodOrGroup,
            'presenter' => $this,
        ]);
    }

    /**
     * Set a translation callback for method titles, descriptions, for parameter descriptions
     * If no callback is set, no translations are made
     * @param callable $callback
     */
    public function setTranslateCallback(callable $callback)
    {
        $this->callbackTranslate = $callback;
    }

    public function translate($string)
    {
        if (is_callable($this->callbackTranslate)) {
            return call_user_func($this->callbackTranslate, $string);
        }
        return $string;
    }

    /**
     * Set API domain
     * @param string $domain
     * @return self
     */
    public function setDomain($domain)
    {
        $this->domain = rtrim($domain, '/');
        return $this;
    }

    /**
     * Get API domain
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Render a view (Using output buffer or laravel, if available)
     * @param $view
     * @param array $data
     * @return string
     */
    public static function view($view, array $data = [])
    {
        // Check if Laravel View class exists
        if (class_exists('View')) {
            $view = self::VIEW_NAMESPACE . '::' . $view;
            /** @noinspection PhpUndefinedClassInspection */
            return \View::make($view, $data)->render();
        }

        // Fake a custom view
        extract($data);
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include __DIR__ . '/../../views/' . $view . '.php';
        return ob_get_clean();
    }


    /**
     * Get URL for this method within the documentation page
     * @param Method $method
     * @return string
     */
    public static function getMethodDocUrl(Method $method)
    {
        return '#' . self::getMethodDocElementName($method);
    }

    /**
     * Get <a name=..> for documentation page element
     * @param Method $method
     * @return string
     */
    public static function getMethodDocElementName(Method $method)
    {
        return Str::slug($method::METHOD . '-' . $method::URI);
    }

    /**
     * Get URL for this group within the documentation page
     * @param MethodGroup $method
     * @return string
     */
    public static function getGroupDocUrl(MethodGroup $method)
    {
        return '#' . self::getGroupDocElementName($method);
    }

    /**
     * Get <a name=..> for documentation page element
     * @param MethodGroup $method
     * @return string
     */
    public static function getGroupDocElementName(MethodGroup $method)
    {
        return Str::slug('group-' . $method->getTitle());
    }
}