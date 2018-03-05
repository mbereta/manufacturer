<?php

namespace Powerbody\Manufacturer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Manufacturer extends AbstractDb
{
    protected $_idFieldName = 'id';

    protected $_mainTable = 'manufacturer';

    protected function _construct()
    {
        $this->_init($this->_mainTable, $this->_idFieldName);
    }
}
