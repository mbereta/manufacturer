<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Model\ResourceModel;

use \Powerbody\Bridge\Model\Imported\Manufacturer as ImportedManufacturer;
use \Powerbody\Manufacturer\Model\Manufacturer;
use Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Collection;

interface ManufacturerRepositoryInterface
{
    public function getAll() : Collection;

    public function getManufacturerByImportedManufacturer(ImportedManufacturer $importedManufacturerModel) : Manufacturer;

    public function getManufacturerById(int $manufacturerId) : Manufacturer;

    public function getManufacturerArrayForProducts(array $productIdsArray) : array;

    public function getManufacturersWithAttributeOptionId() : Collection;

    public function save(Manufacturer $manufacturer);
}
