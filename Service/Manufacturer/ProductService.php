<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Service\Manufacturer;

use Powerbody\Manufacturer\Model\Manufacturer\ProductFactory as ManufacturerProductFactory;
use Powerbody\Manufacturer\Model\ResourceModel\Manufacturer\Product as ManufacturerProductResourceModel;
use Magento\Catalog\Model\Product as CatalogProduct;

class ProductService implements ProductServiceInterface //, ManufacturerOptionIdProviderInterface
{
    private $manufacturerProductResourceModel;

    private $manufacturerProductFactory;

    public function __construct(
        ManufacturerProductResourceModel $manufacturerProductResourceModel,
        ManufacturerProductFactory $manufacturerProductFactory
    ) {
        $this->manufacturerProductResourceModel = $manufacturerProductResourceModel;
        $this->manufacturerProductFactory = $manufacturerProductFactory;
    }

    public function createManufacturerProduct(int $manufacturerId, int $productId)
    {
        $manufacturerProductModel = $this->manufacturerProductFactory->create();
        $manufacturerProductModel->setData(
            [
                'product_id' => $productId,
                'manufacturer_id' => $manufacturerId
            ]
        );

        $this->manufacturerProductResourceModel->save($manufacturerProductModel);
    }
        
    public function getManufacturerOptionIdFromConfigurableProduct(CatalogProduct $productModel) : int
    {
        $childrenProductsArray = $productModel->getTypeInstance()->getUsedProducts($productModel);
        
        /* @var $childProductModel \Magento\Catalog\Model\Product */
        foreach ($childrenProductsArray as $childProductModel) {
            if (null !== $childProductModel->getData('manufacturer')) {
                return intval($childProductModel->getData('manufacturer'));
            }
        }

        $isImported = $productModel->getData('is_imported');

        if(is_null($isImported)){
            return -1;
        }

        throw new ManufacturerOptionIdNotFoundException;
    }
}
