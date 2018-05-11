<?php

namespace App\Http;

/**
 * Class Response
 * @package App\Http
 */
class Response
{
    /**
     * @var mixed
     */
    private $payload;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * Response constructor.
     * @param $payload
     * @param int $statusCode
     */
    public function __construct($payload, $statusCode = 200)
    {
        $this->payload = $payload;
        $this->headers = [];
        $this->statusCode = $statusCode;
    }

    /**
     * @param $payload
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     *
     */
    public function send()
    {
        $this->sendHeaders();
        http_response_code($this->statusCode);

        echo $this->payload;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     *
     */
    private function sendHeaders()
    {
        foreach ($this->headers as $name => $value) {
            header($name.': '.$value, false, $this->statusCode);
        }
    }
}
