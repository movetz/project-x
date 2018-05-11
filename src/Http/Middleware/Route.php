<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

/**
 * Class Route
 * @package App\Http\Middleware
 */
class Route
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var array
     */
    private $pipeline;

    /**
     * @var string
     */
    private $method;

    /**
     * Route constructor.
     * @param string $pattern
     * @param $pipeline
     * @param string $method
     */
    public function __construct(string $pattern, $pipeline, string $method = Request::METHOD_GET)
    {
        $this->pattern = $pattern;
        $this->pipeline = is_array($pipeline) ? $pipeline : [$pipeline];
        $this->method = $method;
    }

    /**
     * @param string $pattern
     * @param $pipeline
     * @return Route
     */
    public static function post(string $pattern, $pipeline): Route
    {
        return new static($pattern, $pipeline, Request::METHOD_POST);
    }

    /**
     * @param string $pattern
     * @param $pipeline
     * @return Route
     */
    public static function get(string $pattern, $pipeline): Route
    {
        return new static($pattern, $pipeline);
    }

    /**
     * @param Request $request
     * @param callable $next
     * @return array|Response
     */
    public function __invoke(Request $request, callable $next)
    {
        if ($request->isMethod($this->method) && $this->match($request)) {
            return $this->pipeline;
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function match(Request $request)
    {
        $pattern = str_replace('/', '\/', $this->pattern);

        $matches = [];
        if (0 === preg_match("/$pattern$/", $request->getUri(), $matches)) {
            return false;
        }

        array_shift($matches);
        $request->setMeta('route', $matches);
        return true;
    }
}
