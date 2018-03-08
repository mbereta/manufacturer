<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Entity;

use Powerbody\Manufacturer\Entity\ManufacturerRepositoryInterface;
use Powerbody\Manufacturer\Model\ManufacturerFactory as ManufacturerFactory;
use Powerbody\Manufacturer\Model\Manufacturer as Manufacturer;

class ManufacturerRepository implements ManufacturerRepositoryInterface
{

    /**
     * @var \Powerbody\Manufacturer\Model\ManufacturerFactory
     */
    private $manufacturerFactory;

    public function __construct(ManufacturerFactory $manufacturerFactory)
    {
        $this->manufacturerFactory = $manufacturerFactory;
    }

    public function getManufacturerById(int $manufacturerId) : Manufacturer
    {
        /** @var Manufacturer $manufacturerModel */
        $manufacturerModel = $this->manufacturerFactory->create();

        if (false !== boolval($manufacturerId)) {
            $manufacturerModel->getResource()->load($manufacturerModel, $manufacturerId);
        }

        return $manufacturerModel;
    }

    public function getManufacturerByOptionId(int $manufacturerOptionId) : Manufacturer
    {
        return $this->manufacturerFactory
            ->create()
            ->getCollection()
            ->addFieldToFilter('attribute_option_id', $manufacturerOptionId)
            ->getFirstItem();
    }

}
