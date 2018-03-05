<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Entity;
use Powerbody\Manufacturer\Model\Manufacturer as Manufacturer;

interface ManufacturerRepositoryInterface
{
    public function getManufacturerById(int $manufacturerId) : Manufacturer;
    
    public function getManufacturerByOptionId(int $manufacturerOptionId) : Manufacturer;
}
