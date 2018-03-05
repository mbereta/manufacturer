<?php

namespace Powerbody\Manufacturer\Model\ResourceModel\Manufacturer;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Product extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('manufacturer_product', 'id');
    }
}
