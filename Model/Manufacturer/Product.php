<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Model\Manufacturer;

use Magento\Framework\Model\AbstractModel;
use Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Product as ResourceModel;

class Product extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
