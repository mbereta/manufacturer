<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Block;

use Magento\Framework\View\Element\Template;
use Powerbody\Manufacturer\Model\ResourceModel\ManufacturerRepositoryInterface;
use Magento\Framework\UrlInterface;

class Manufacturer extends Template
{
    /* var Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Product */
    private $manufacturerRepository;
    
    /* @var Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Collection */
    private $manufacturers = null;

     /* @var Magento\Framework\UrlInterface */
    private $urlBuilder;

    public function __construct(
        Template\Context $context, 
        ManufacturerRepositoryInterface $manufacturerRepositoryInterface,
        UrlInterface $urlBuilder,
        array $data = array()
    ) {
        $this->manufacturerRepository = $manufacturerRepositoryInterface;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    public function getManufacturers() : array
    {
        if (null === $this->manufacturers) {
            $this->manufacturers = $this->manufacturerRepository->getManufacturersWithAttributeOptionId();
        }

        $manufacturers = [];
        /* @var $manufacturer Powerbody_Manufacturer_Model_Manufacturer */
        foreach ($this->manufacturers as $manufacturer) {
            $firstLetter = strtoupper($manufacturer->getData('name')[0]);
            if (is_numeric($firstLetter)) {
                $manufacturers['numbers'][] = $manufacturer;
            } else {
                $manufacturers[$firstLetter][] = $manufacturer;
            }
        }

        return $manufacturers;
    }

    public function getManufacturerLogoUrl(string $filename) : string
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'manufacturer/' . $filename;
    }
    
    public function getManufacturerUrl(\Powerbody\Manufacturer\Model\Manufacturer $manufacturerModel) : string
    {
        return $this->getUrl('manufacturer/index/view',
            [
                'bid' => $manufacturerModel->getId(),
                '_query' => 'manufacturer=' . $manufacturerModel->getData('attribute_option_id'),
            ]
        );
    }
}
