<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Powerbody\Manufacturer\Service\ConfigurationReaderInterface;
use Powerbody\Manufacturer\Service\Manufacturer\MarginServiceInterface;

class MinimalMarginChangeSubscriber implements ObserverInterface
{
    private $marginService;
    private $configurationReader;

    public function __construct(
        MarginServiceInterface $marginService,
        ConfigurationReaderInterface $configurationReader
    ) {
        $this->marginService = $marginService;
        $this->configurationReader = $configurationReader;
    }

    public function execute(Observer $observer)
    {
        try {
            $this->marginService->adjustMarginToNewMinimal($this->configurationReader->getMinimalMargin());
        } catch (\Exception $e) {}
    }
}
