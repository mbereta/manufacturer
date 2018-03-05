<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Service\Manufacturer;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\NoSuchEntityException;
use Powerbody\Manufacturer\Model\Manufacturer;
use Powerbody\Manufacturer\Model\ResourceModel\ManufacturerRepositoryInterface;
use Powerbody\Manufacturer\Provider\Manufacturer\ProductsProviderInterface;
use Powerbody\Manufacturer\Service\ConfigurationReaderInterface;

class MarginService implements MarginServiceInterface
{
    private $manufacturerRepository;

    private $productRepository;

    private $productsProvider;

    private $configurationReader;

    public function __construct(
        ManufacturerRepositoryInterface $manufacturerRepository,
        ProductRepositoryInterface $productRepository,
        ProductsProviderInterface $productsProvider,
        ConfigurationReaderInterface $configurationReader
    ) {
        $this->manufacturerRepository = $manufacturerRepository;
        $this->productRepository = $productRepository;
        $this->productsProvider = $productsProvider;
        $this->configurationReader = $configurationReader;
    }

    public function updateManufacturerMargin(int $manufacturerId, int $newMargin)
    {
        $manufacturer = $this->manufacturerRepository->getManufacturerById($manufacturerId);
        if (null === $manufacturer->getId()) {
            throw new NoSuchEntityException();
        }

        if ($newMargin < $this->configurationReader->getMinimalMargin()) {
            throw new NewMarginTooLowException();
        }

        $manufacturer->setData('margin', $newMargin);
        $this->manufacturerRepository->save($manufacturer);
    }

    public function getPriceIncludingMargin(Product $product) : float
    {
        /** @var Manufacturer $manufacturer */
        $manufacturer = $this->manufacturerRepository
            ->getManufacturersWithAttributeOptionId()
            ->addFieldToFilter('attribute_option_id', ['in' => $product->getData('manufacturer')])
            ->getFirstItem();

        return round(
            $this->calculatePriceIncludingMargin($product, (int)$manufacturer->getData('margin')),
            2
        );
    }

    public function adjustMarginToNewMinimal(int $newMinimalMargin)
    {
        $manufacturers = $this->manufacturerRepository
            ->getAll()
            ->addFieldToFilter('margin', ['lt' => $newMinimalMargin]);

        foreach ($manufacturers as $manufacturer) {
            $manufacturer->setData('margin', $newMinimalMargin);
            $this->manufacturerRepository->save($manufacturer);
            $this->recalculatePrices((int) $manufacturer->getId(), $newMinimalMargin);
        }
    }

    private function recalculatePrices(int $manufacturerId, int $newMargin)
    {
        $products = $this->productsProvider
            ->findAllByManufacturerId($manufacturerId)
            ->addAttributeToSelect('base_price');
                
        if ($products->getSize() < 1) {
            return;
        }
        
        foreach ($products as $product) { /** @var $product Product */
            $productWithNewMargin = $this->applyMargin($product, $newMargin);
            $this->productRepository->save($productWithNewMargin);
        }
    }

    private function applyMargin(Product $product, int $newMargin) : Product
    {
        $newPrice = $this->calculatePriceIncludingMargin($product, $newMargin);
        $product->setPrice($newPrice);

        return $product;
    }

    private function calculatePriceIncludingMargin(Product $product, int $newMargin) : float
    {
        $basePrice = $product->getData('base_price');

        return $basePrice * (1 + $newMargin / 100);
    }
}
