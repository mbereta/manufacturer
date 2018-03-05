<?php

namespace Powerbody\Manufacturer\Block\Adminhtml\Index;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

/**
 * Class Index
 * @package Powerbody\Manufacturer\Block\Adminhtml\Index\Index
 */
class Index extends Template
{
    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
