<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Setup\Command;

use Magento\Catalog\Api\Data\ProductInterface;

class AssignPriceToBasePrice
{
    private $products;

    /**
     * @param $products ProductInterface[]
     */
    public function __construct(array $products)
    {
        array_walk($products, function ($item) {
            if (!$item instanceof ProductInterface) {
                throw new \InvalidArgumentException(
                    'Product should implement '.ProductInterface::class.', '.get_class($item).' given.'
                );
            }
        });
        $this->products = $products;
    }

    /**
     * @return ProductInterface[]
     */
    public function products() : array
    {
        return $this->products;
    }
}
