<?php

namespace Powerbody\Manufacturer\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Powerbody\Manufacturer\Model\ResourceModel\ManufacturerRepositoryInterface;

class MenuList extends Template implements BlockInterface
{
    const MAX_COLUMNS = 4;

    protected $_template = "widget/list.phtml";

    /* var Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Product */
    private $manufacturerRepository;

    private $manufacturers = null;

    public function __construct(
        Template\Context $context,
        ManufacturerRepositoryInterface $manufacturerRepositoryInterface,
        array $data = array()
    )
    {
        $this->manufacturerRepository = $manufacturerRepositoryInterface;
        parent::__construct($context, $data);
    }

    public function getManufacturers()
    {
        if (null === $this->manufacturers) {
            $manufacturers = $this->manufacturerRepository
                ->getManufacturersWithAttributeOptionId()
                ->getItems();

            $this->manufacturers = [];

            $perColumn = floor(count($manufacturers) / self::MAX_COLUMNS);
            $rest = count($manufacturers) % self::MAX_COLUMNS;

            $from = 0;
            for ($i = 0; $i < self::MAX_COLUMNS; $i++) {

                if ($i < $rest) {
                    $count = $perColumn + 1;
                } else {
                    $count = $perColumn;
                }

                $this->manufacturers[$i] = array_slice($manufacturers, $from, $count);

                $from += $count;
            }
        }

        return $this->manufacturers;
    }
}
