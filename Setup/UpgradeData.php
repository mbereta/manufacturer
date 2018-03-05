<?php

namespace Powerbody\Manufacturer\Setup;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\State;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\Product;
use Powerbody\Manufacturer\Setup\Command\AssignPriceToBasePrice;
use Powerbody\Manufacturer\Setup\Command\AssignPriceToBasePriceHandler;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

    private $handler;

    private $productRepository;

    private $searchCriteriaBuilder;

    private $state;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ProductRepositoryInterface $productRepository,
        AssignPriceToBasePriceHandler $handler,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        State $state
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->handler = $handler;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->state = $state;
    }
    
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            /* @var $eavSetup EavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $attributeCode = 'manufacturer';
            $attributeLabel = 'Manufacturer';
            $attributeId = $eavSetup->getAttributeId(Product::ENTITY, $attributeCode);
            if (false === $attributeId) {
                $eavSetup->addAttribute(
                    Product::ENTITY,
                    $attributeCode,
                    [
                        'group'                     => 'General',
                        'type'                      => 'int',
                        'backend'                   => '',
                        'frontend'                  => '',
                        'label'                     => $attributeLabel,
                        'input'                     => 'select',
                        'class'                     => '',
                        'source'                    => '',
                        'global'                    => Attribute::SCOPE_GLOBAL,
                        'visible'                   => true,
                        'required'                  => false,
                        'user_defined'              => true,
                        'default'                   => '',
                        'searchable'                => false,
                        'filterable'                => false,
                        'comparable'                => false,
                        'visible_on_front'          => false,
                        'used_in_product_listing'   => true,
                        'unique'                    => false,
                        'apply_to'                  => ''
                    ]
                );
            } else {
                $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, $attributeId, 'backend_type', 'int');
                $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, $attributeId, 'frontend_input', 'select');
            }
            $eavSetup->addAttributeToSet(\Magento\Catalog\Model\Product::ENTITY, 'Default', 'General', $attributeCode);
        }

        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            /* @var $eavSetup EavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $attributeCode = 'base_price';
            if (false === $eavSetup->getAttributeId(Product::ENTITY, $attributeCode)) {
                $eavSetup->addAttribute(
                    Product::ENTITY, $attributeCode, [
                        'type' => 'decimal',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Base price',
                        'input' => '',
                        'class' => '',
                        'source' => '',
                        'global' => Attribute::SCOPE_GLOBAL,
                        'visible' => false,
                        'required' => false,
                        'user_defined' => false,
                        'default' => 0,
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => false,
                        'used_in_product_listing' => false,
                        'unique' => false,
                        'apply_to' => ''
                    ]
                );
            }
        }
        
        if (version_compare($context->getVersion(), '1.0.7', '<')) {
            /* @var $eavSetup EavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $manufacturerAttributeCode = 'manufacturer';
            $manufacturerAttributeId = $eavSetup->getAttributeId(Product::ENTITY, $manufacturerAttributeCode);

            if (false !== $manufacturerAttributeId) {
                $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, $manufacturerAttributeId, 'is_filterable', 2);
                $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, $manufacturerAttributeId, 'position', 10);
            }
            
            $priceAttributeCode = 'price';
            $priceAttributeId = $eavSetup->getAttributeId(Product::ENTITY, $priceAttributeCode);
            
            if (false !== $priceAttributeId) {
                $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, $priceAttributeId, 'position', 20);
            }     
            
        }
    }
}
