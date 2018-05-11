<?php

namespace App\Domain;

/**
 * Class Paginator
 * @package App\Domain
 */
class Paginator
{
    /**
     * @var int
     */
    private $total;

    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $offset;

    /**
     * Paginator constructor.
     * @param int $total
     * @param array $data
     * @param int $offset
     */
    public function __construct(int $total, array $data, int $offset)
    {

        $this->total = $total;
        $this->data = $data;
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
