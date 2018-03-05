<?php
namespace Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\Datetime;
use Magento\Framework\DataObject;

/**
 * Class Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Column\Renderer\Date
 */
class Date extends Datetime
{            
    /**     
     * @param   DataObject $row
     * @return  string
     */
    public function render(DataObject $row)
    {
        $format = $this->getColumn()->getFormat();        
        $date = $this->_getValue($row);
        if ($date) {
            if (!($date instanceof \DateTimeInterface)) {
                $date = new \DateTime($date);
            }
            return $this->_localeDate->formatDateTime(
                $date,
                $format ?: \IntlDateFormatter::MEDIUM,
                $format ?: \IntlDateFormatter::MEDIUM,
                null,
                $this->getColumn()->getTimezone() === false ? 'UTC' : null,
                $this->getColumn()->getData('pattern')
            );
        }
        return $this->getColumn()->getDefault();
    }
}
