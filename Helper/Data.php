<?php

namespace Powerbody\Manufacturer\Helper;

use Powerbody\Manufacturer\Model\ResourceModel\ManufacturerRepositoryInterface as ManufacturerRepository;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /* @var ManufacturerRepository */
    private $manufacturerRepository;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        ManufacturerRepository $manufacturerRepository
    ) {
        parent::__construct($context);
        $this->manufacturerRepository = $manufacturerRepository;

    }

    public function getManufacturerArrayForProducts($productCollection)
    {
        $productIdsArray = $productCollection->getColumnValues('entity_id');

        return $this->manufacturerRepository->getManufacturerArrayForProducts($productIdsArray);
    }

}
