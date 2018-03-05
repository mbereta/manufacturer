<?php

namespace Powerbody\Manufacturer\Model\ResourceModel\Manufacturer;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Powerbody\Manufacturer\Model\Manufacturer as Model;
use Powerbody\Manufacturer\Model\ResourceModel\Manufacturer as ResourceModel;

/**
 * Class Collection
 * @package Powerbody\Manufacturer\Model\ResourceModel\Manufacturer
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
