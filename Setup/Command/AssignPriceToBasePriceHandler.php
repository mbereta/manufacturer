<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Setup\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Powerbody\Manufacturer\Service\ConfigurationReaderInterface;
use Powerbody\Manufacturer\Service\Manufacturer\MarginServiceInterface;

class AssignPriceToBasePriceHandler
{
    private $configurationReader;

    public function __construct(ConfigurationReaderInterface $configurationReader) {
        $this->configurationReader = $configurationReader;
    }

    public function handle(AssignPriceToBasePrice $command)
    {
        foreach ($command->products() as $product) {
            /** @var $product Product */
            $product->setData('base_price', $product->getPrice());
            $product->getResource()->saveAttribute($product, 'base_price');
        }
    }
}
