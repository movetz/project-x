<?php

namespace App\Http;

use App\Container;

/**
 * Class Pipeline
 * @package App\Http
 */
class Pipeline
{
    /**
     * @var \ArrayIterator
     */
    private $iterator;

    /**
     * @var Container
     */
    private $container;

    /**
     * Pipeline constructor.
     * @param Container $container
     * @param array $pipes
     */
    public function __construct(Container $container, array $pipes)
    {
        $this->iterator = new \ArrayIterator($pipes);
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function run(Request $request): Response
    {
        $first = $this->next();
        return $first($request);
    }

    /**
     * @return \Closure
     */
    private function next()
    {
        return function (Request $request) {
            $pipe = $this->getPipe();

            if (!is_callable($pipe)) {
                throw new PipelineException('The pipe should be the callable.');
            }

            $this->iterator->next();
            $response = $pipe($request, $this->next());

            if (is_array($response)) {
                return (new static($this->container, $response))->run($request);
            }

            return $response;
        };
    }

    /**
     * @return mixed
     */
    private function getPipe()
    {
        $pipe = $this->iterator->current();
        return (is_callable($pipe) || is_object($pipe)) ? $pipe : $this->container->get($pipe);
    }
}
