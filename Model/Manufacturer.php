<?php
namespace Powerbody\Manufacturer\Model;

use Magento\Framework\Model\AbstractModel;
use Powerbody\Manufacturer\Model\ResourceModel\Manufacturer as ResourceModel;

/**
 * Class Manufacturer
 * @package Powerbody\Manufacturer\Model
 */
class Manufacturer extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
