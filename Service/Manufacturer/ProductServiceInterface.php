<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Service\Manufacturer;

interface ProductServiceInterface
{
    public function createManufacturerProduct(int $manufacturerId, int $productId);
}
