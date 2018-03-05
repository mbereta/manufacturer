<?php

namespace Powerbody\Manufacturer\Service\Manufacturer;

use Magento\Catalog\Model\Product;

interface MarginServiceInterface
{
    public function updateManufacturerMargin(int $manufacturerId, int $newMargin);

    public function getPriceIncludingMargin(Product $product) : float;

    public function adjustMarginToNewMinimal(int $newMinimalMargin);
}
