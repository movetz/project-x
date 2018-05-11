<?php

namespace App\Domain\Product;

use App\Domain\Paginator;

/**
 * Class ProductRepository
 * @package App\Domain\Product
 */
class ProductRepository
{
    /**
     * @param $id
     * @return mixed
     * @throws ProductNotFoundException
     */
    public function getOne($id)
    {
        foreach ($this->generate() as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }

        throw new ProductNotFoundException();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Paginator
     */
    public function getAll(int $limit, int $offset): Paginator
    {
        $products = iterator_to_array($this->generate());
        return new Paginator(
            count($products),
            array_slice($products, $offset, $limit),
            $offset
        );
    }

    /**
     * @return \Generator
     */
    private function generate()
    {
        foreach (range(1, 50) as $id) {
            yield [
                'id'    => $id,
                'name'  => 'Product name. With #id - '.$id,
                'price' => rand(100, 500) / 100,
            ];
        }
    }
}
