<?php

namespace Briedis\ApiBuilder;

use Closure;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class to help build routes
 */
class RouteBuilder
{
    /** @var Registrar */
    private $registrar;

    /**
     * @param Registrar $registrar
     */
    public function __construct(Registrar $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * Generate a route for a given method
     * @param Method|string $method Instance of method or fully qualified name (::class)
     * @param array|Closure|null|string $routeAction
     * @return self
     */
    public function add($method, $routeAction)
    {
        $mapping = [
            'GET' => 'get',
            'POST' => 'post',
            'PUT' => 'put',
            'DELETE' => 'delete',
            'PATCH' => 'patch',
        ];

        if (!isset($mapping[$method::METHOD])) {
            throw new \InvalidArgumentException('Unknown method type: ' . $method::METHOD);
        }

        $routeMethod = $mapping[$method::METHOD];

        // If action is a string, convert it to an array with 'uses' field
        if (is_string($routeAction)) {
            $routeAction = ['uses' => $routeAction];
        }

        // Store method in route, so we can perform validation in the middleware by retrieving the api method
        // Note: validation is not possible for closure style actions
        if (is_array($routeAction)) {
            $routeAction[ApiMethodValidationMiddleware::ACTION_ENDPOINT_KEY] = is_string($method) ? $method : get_class($method);
        }

        call_user_func([$this->registrar, $routeMethod], $method::URI, $routeAction);

        return $this;
    }
}