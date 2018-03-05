<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\Page;
use Powerbody\Manufacturer\Model\ManufacturerFactory as ManufacturerFactory;

class View extends Action
{
    /* @var PageFactory */
    protected $resultPageFactory;

    /* @var ForwardFactory */
    protected $resultForwardFactory;

    /**
     * @var ManufacturerFactory
     */
    private $manufacturerFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        ManufacturerFactory $manufacturerFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->manufacturerFactory = $manufacturerFactory;

        parent::__construct($context);
    }

    /**
     * @return Forward | Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        if (!$resultPage) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        $resultPage->getConfig()->getTitle()
            ->set($this->getManufacturerName());

        return $resultPage;
    }

    private function getManufacturerName() : string
    {
        $manufacturerId = $this->getRequest()->getParam('bid');

        $manufacturer = $this->manufacturerFactory
            ->create()
            ->load($manufacturerId);

        return $manufacturer->getData('name');
    }

}
