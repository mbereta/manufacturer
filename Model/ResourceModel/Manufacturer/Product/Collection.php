<?php

namespace Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Product;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Powerbody\Manufacturer\Model\Manufacturer\Product as Model;
use Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Product as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
