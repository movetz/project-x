<?php

namespace App\Domain\Product;

/**
 * Class ProductNotFoundException
 * @package App\Domain\Product
 */
class ProductNotFoundException extends \Exception
{
    /**
     * ProductNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Product not found');
    }
}
