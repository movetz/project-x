<?php

namespace App\Http;

/**
 * Class Request
 * @package App\Http
 */
class Request
{
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $queryParams;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @var array
     */
    private $meta;

    /**
     * Request constructor.
     * @param string $uri
     * @param string $method
     * @param array $queryParams
     * @param array $headers
     * @param mixed $body
     */
    public function __construct(string $uri, string $method, array $headers = [], array $queryParams = [], $body = null)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->queryParams = $queryParams;
        $this->body = $body;
        $this->headers = $headers;
        $this->meta = [];
    }

    /**
     * @return Request
     */
    public static function create(): Request
    {
        $request = new static(
            $_SERVER['PATH_INFO'],
            $_SERVER['REQUEST_METHOD'],
            getallheaders()
        );

        parse_str($_SERVER['QUERY_STRING'] ?? '', $request->queryParams);


        if ($request->isMethod(self::METHOD_POST)) {
            $request->body = file_get_contents('php://input');
        }

        return $request;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isMethod(string $string): bool
    {
        return $this->method == $string;
    }


    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function getQueryParam(string $key, $default = null)
    {
        return $this->queryParams[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function getHeader(string $key, $default = null)
    {
        return $this->headers[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function getMeta(string $key, $default = null)
    {
        return $this->meta[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param $meta
     */
    public function setMeta(string $key, $meta): void
    {
        $this->meta[$key] = $meta;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }
}
