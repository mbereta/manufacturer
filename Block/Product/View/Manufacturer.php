<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Block\Product\View;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;
use Powerbody\Manufacturer\Entity\ManufacturerRepositoryInterface;
use Powerbody\Theme\Exception\ManufacturerOptionIdNotFoundException;
use Powerbody\Manufacturer\Service\Manufacturer\ProductService;

class Manufacturer extends AbstractProduct
{

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(
        Context $context,
        ManufacturerRepositoryInterface $manufacturerRepositoryInterface,
        ProductService $productService,
        array $data = array()
    ) {
        $this->manufacturerRepository = $manufacturerRepositoryInterface;
        $this->productService = $productService;

        parent::__construct($context, $data);

        if (null === $this->getTemplate()) {
            $this->setTemplate('Powerbody_Manufacturer::product/list/manufacturer.phtml');
        }
    }

    /**
     * @return \Powerbody\Manufacturer\Model\Manufacturer
     */
    public function getManufacturer()
    {
        /* @var $product \Magento\Catalog\Model\Product */
        $product = $this->getProduct();

        $isImported = $product->getData('is_imported');

        $manufacturerId = intval($product->getData('manufacturer'));

        if (is_null($isImported)) {
            $manufacturerId = -1;
        }

        if (true === $product->canConfigure() && null === $product->getData('manufacturer')) {
            try {
                $manufacturerId = intval($this->productService->getManufacturerOptionIdFromConfigurableProduct($product));
            } catch (ManufacturerOptionIdNotFoundException $e) {}
        }

        return $this->manufacturerRepository->getManufacturerByOptionId($manufacturerId);
    }

    /**
     * @param \Powerbody\Manufacturer\Model\Manufacturer $manufacturer
     * @return string
     */
    public function getManufacturerListUrl(\Powerbody\Manufacturer\Model\Manufacturer $manufacturer)
    {
        return $this->getUrl('manufacturer/index/view',
            [
                'bid' => $manufacturer->getId(),
                '_query' => 'manufacturer=' . $manufacturer->getData('attribute_option_id')
            ]
        );
    }

    public function getManufacturerUrl() : string
    {
        return $this->getUrl('manufacturer/index/view',
            [
                'bid' => $this->getProduct()->getData('manufacturer'),
                '_query' => 'manufacturer=' . $this->getProduct()->getData('manufacturer_option_id'),
            ]
        );
    }

}
