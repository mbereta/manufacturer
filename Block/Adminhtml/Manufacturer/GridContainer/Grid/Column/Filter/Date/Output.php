<?php
namespace Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Grid\Column\Filter\Date;

use Magento\Framework\View\Element\Template;

/**
 * Class Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Grid\Column\Filter\Date\Output
 */
class Output extends Template
{
    /**
     * Construct
     */
    public function _construct()
    {
        $this->setData('template', 'Powerbody_Manufacturer::manufacturer/grid/filter/date.phtml');
        parent::_construct();
    }
}
