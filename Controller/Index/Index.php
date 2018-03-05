<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\Page;

class Index extends Action
{
    /* @var PageFactory */
    protected $resultPageFactory;

    /* @var ForwardFactory */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
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
        
        $resultPage->getConfig()->getTitle()->set(__('Manufacturers list'));

        return $resultPage;
    }
}
