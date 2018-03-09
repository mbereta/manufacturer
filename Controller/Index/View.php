<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\Page;
use Powerbody\Manufacturer\Entity\ManufacturerRepository;
use Powerbody\Manufacturer\Model\Manufacturer;

class View extends Action
{
    /* @var PageFactory */
    protected $resultPageFactory;

    /* @var ForwardFactory */
    protected $resultForwardFactory;

    /** @var ManufacturerRepository */
    protected $manufacturerRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        ManufacturerRepository $manufacturerRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->manufacturerRepository = $manufacturerRepository;

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
        $manufacturerId = (int)$this->getRequest()->getParam('bid');
        /** @var Manufacturer $manufacturer */
        $manufacturer = $this->manufacturerRepository->getManufacturerByOptionId($manufacturerId);

        if (true === empty($manufacturer)) {
            $manufacturer = $this->manufacturerRepository->getManufacturerById($manufacturerId);
        }

        return $manufacturer->getData('name');
    }
}
