<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Powerbody\Manufacturer\Service\Manufacturer\MarginServiceInterface;
use Powerbody\Manufacturer\Service\Manufacturer\NewMarginTooLowException;

class MarginAjax extends Action 
{
    private $jsonFactory;

    private $marginService;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        MarginServiceInterface $marginService
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->marginService = $marginService;
        parent::__construct($context);
    }

    public function execute() : Json
    {
        $result = $this->jsonFactory->create();

        foreach ($this->getRequest()->getParam('items') as $item) {
            try {
                $manufacturerId = (int) $item['id'];
                $newMargin = (int) $item['margin'];
                $this->marginService->updateManufacturerMargin($manufacturerId, $newMargin);
                return $result->setData(['error' => false, 'messages' => ['Margin updated.'],]);
            } catch (NewMarginTooLowException $e) {
                return $result->setData(['error' => true, 'messages' => ['Requested margin is too low.'],]);
            } catch (NoSuchEntityException $e) {
                return $result->setData(['error' => true, 'messages' => ['Manufacturer not found.'],]);
            } catch (\Exception $e) {
                return $result->setData(['error' => true, 'messages' => [$e->getMessage()],]);
            }
        }

        return $result->setData(['qwe' => 1]);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Powerbody_Manufacturer::index');
    }

}
