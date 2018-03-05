<?php
namespace Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Grid\Column\Filter;

use Magento\Backend\Block\Widget\Grid\Column\Filter\Datetime;

/**
 * Class Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Column\Filter\Date
 */
class Date extends Datetime
{            
    /**     
     * @return string
     */
    public function getHtml()
    {        
        $timeFormat = '';
        if ($this->getColumn()->getFilterTime()) {
            $timeFormat = $this->_localeDate->getTimeFormat(
                \IntlDateFormatter::SHORT
            );
        }
        
        return $this->getLayout()
            ->createBlock('Powerbody\Manufacturer\Block\Adminhtml\Manufacturer\GridContainer\Grid\Column\Filter\Date\Output')
            ->setData([
                'dateFormat'    => $this->getColumn()->getData('filter_pattern'),
                'fromValue'     => $this->getEscapedValue('from'),
                'htmlId'        => $this->mathRandom->getUniqueHash($this->_getHtmlId()),
                'htmlName'      => $this->_getHtmlName(),
                'locale'        => $this->localeResolver->getLocale(),
                'showsTime'     => $this->getColumn()->getFilterTime() ? 'true' : '',
                'timeFormat'    => $timeFormat,
                'toValue'       => $this->getEscapedValue('to'),
                'uiFromId'      => $this->getUiId('filter', $this->_getHtmlName(), 'from'),
                'uiToId'        => $this->getUiId('filter', $this->_getHtmlName(), 'to')
            ])->toHtml();
    }       
    
    /**     
     * @param string $date
     * @return \DateTime|null
     */
    protected function _convertDate($date)
    {
        $timezone = $this->getColumn()->getTimezone() !== false ? $this->_localeDate->getConfigTimezone() : 'UTC';
        $adminTimeZone = new \DateTimeZone($timezone);
        $formatter = new \IntlDateFormatter(
            $this->localeResolver->getLocale(),
            \IntlDateFormatter::SHORT,
            \IntlDateFormatter::NONE,
            $adminTimeZone,
            null,                
            $this->getColumn()->getData('filter_pattern')                
        );
        $simpleRes = new \DateTime(null, $adminTimeZone);
        $simpleRes->setTimestamp($formatter->parse($date));
        $simpleRes->setTime(0, 0, 0);
        $simpleRes->setTimezone(new \DateTimeZone('UTC'));
        return $simpleRes;
    }
    
}
