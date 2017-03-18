<?php


namespace Briedis\ApiBuilder;


use Briedis\ApiBuilder\Exceptions\InvalidResponseStructureException;
use Briedis\ApiBuilder\Exceptions\InvalidStructureException;
use Closure;

class ApiMethodValidationMiddleware
{
    /**
     * Key used to store endpoint class name in routes
     */
    const ACTION_ENDPOINT_KEY = 'apiBuilderMethod';

    /**
     * @param mixed $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidStructureException
     */
    public function handle($request, Closure $next)
    {
        $apiEndpointClass = array_get($request->route()->getAction(), self::ACTION_ENDPOINT_KEY);

        // If no endpoint is set to route, we do not check anything
        if (!$apiEndpointClass) {
            return $next($request);
        }

        $apiEndpoint = false;
        if ($apiEndpointClass) {
            /** @var Method $apiEndpoint */
            $apiEndpoint = new $apiEndpointClass;
        }

        // Validate incoming structure
        (new StructureValidator($apiEndpoint->getRequest()))->validate($request->input());

        $response = $next($request);

        // If response already contains a validation exception, we return it
        // It was probably set when we validated incoming structure
        if ($response->exception instanceof InvalidStructureException) {
            return $response;
        }

        // Validate outgoing structure
        try {
            (new StructureValidator($apiEndpoint->getResponse()))->validate($response->getOriginalContent());
        } catch (InvalidStructureException $e) {
            // This will do for now, but later we should implement a smarter way to throw notify about errors
            \Log::error($e->getFormattedMessage(), [
                'bad' => $e->getBadFields(),
                'missing' => $e->getMissingFields(),
                'unexpected' => $e->getUnexpectedFields(),
            ]);
        }

        return $response;
    }
}
