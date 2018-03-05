<?php

namespace Powerbody\Manufacturer\Provider\Manufacturer;

use Magento\Catalog\Model\ResourceModel\Product\Collection as CatalogProductCollection;

interface ProductsProviderInterface
{
    public function findAllByManufacturerId(int $manufacturerId) : CatalogProductCollection;
}
