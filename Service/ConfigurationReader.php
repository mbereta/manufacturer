<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigurationReader implements ConfigurationReaderInterface
{
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getMinimalMargin() : int
    {
        return (int) $this
            ->scopeConfig
            ->getValue('manufacturer/general/minimal_margin', ScopeInterface::SCOPE_STORE);
    }
}
