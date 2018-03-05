<?php
namespace Powerbody\Manufacturer\Block\Adminhtml\Manufacturer;

use Magento\Backend\Block\Widget\Grid\Container as Container;

/**
 * Class Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer
 */
class GridContainer extends Container 
{
    /**
     * Construct
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Powerbody_Manufacturer';
        $this->_controller = 'adminhtml_manufacturer';
        $this->_headerText = __('Manage Manufacturers');

        parent::_construct();
        $this->removeButton('add');
    }
}
