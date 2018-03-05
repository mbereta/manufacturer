<?php
namespace Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Grid\Column\Filter\Priority;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Options
 * @package Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Grid\Column\Filter\Priority
 */
class Options implements ArrayInterface
{
    const HIGHEST_PRIORITY = 10;
    const LOWEST_PRIORITY = 0;

    /**
     * @var array
     */
    protected $priority;

    public function __construct() 
    {
        $this->priority = range(self::LOWEST_PRIORITY, self::HIGHEST_PRIORITY);
    }    

    /**
     * @return array
     */
    public function toOptionArray() 
    {
        $optionsArray[] = [
            'value' => -1,
            'label' => __(' '),
        ];
        foreach ($this->priority as $priority) {
            $optionsArray[] = [
                'value' => $priority,
                'label' => __($priority),
            ];
        }

        return $optionsArray;
    }
    
    /**
     * @return array
     */
    public function getOptionsArray()
    {
        $optionsArray[-1] = ' ';
        foreach ($this->priority as $priority) {
            $optionsArray[$priority] = $priority;
        }        
        return $optionsArray;
    }
}
