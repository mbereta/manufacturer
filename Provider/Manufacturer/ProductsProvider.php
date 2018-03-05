<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Provider\Manufacturer;

use Magento\Catalog\Model\ResourceModel\Product\Collection as CatalogProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class ProductsProvider implements ProductsProviderInterface
{
    private $productCollectionFactory;

    public function __construct(CollectionFactory $productCollectionFactory)
    {
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function findAllByManufacturerId(int $manufacturerId) : CatalogProductCollection
    {
        /** @var CatalogProductCollection $products */
        $products = $this->productCollectionFactory->create();
        $products->getSelect()->joinLeft(
            ['mp' => 'manufacturer_product'], 'mp.product_id=e.entity_id', 'manufacturer_id'
        );
        $products->getSelect()->group('entity_id');
        $products->getSelect()->where('mp.manufacturer_id = ?', $manufacturerId);

        return $products;
    }
}
