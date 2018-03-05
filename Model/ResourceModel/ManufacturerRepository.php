<?php
declare(strict_types=1);

namespace Powerbody\Manufacturer\Model\ResourceModel;

use Powerbody\Manufacturer\Model\ManufacturerFactory;
use Powerbody\Manufacturer\Model\ResourceModel\Manufacturer as ManufacturerResourceModel;
use \Powerbody\Manufacturer\Model\Manufacturer;
use \Powerbody\Bridge\Model\Imported\Manufacturer as ImportedManufacturer;

class ManufacturerRepository implements ManufacturerRepositoryInterface
{
    private $manufacturerFactory;

    private $manufacturerResourceModel;

    public function __construct(
        ManufacturerFactory $manufacturerFactory,
        ManufacturerResourceModel $manufacturerResourceModel
    ) {
        $this->manufacturerFactory = $manufacturerFactory;
        $this->manufacturerResourceModel = $manufacturerResourceModel;
    }

    public function getAll() : ManufacturerResourceModel\Collection
    {
        return $this->manufacturerFactory->create()->getCollection();
    }

    public function getManufacturerById(int $manufacturerId) : Manufacturer
    {
        $manufacturerModel = $this->manufacturerFactory->create();

        $this->manufacturerResourceModel->load(
            $manufacturerModel,
            $manufacturerId
        );

        return $manufacturerModel;
    }

    public function getManufacturerArrayForProducts(array $productIdsArray) : array
    {
        $manufacturerCollection = $this->manufacturerFactory
            ->create()
            ->getCollection();

        $manufacturerCollection->getSelect()
            ->joinLeft(
                ['mp' => 'manufacturer_product'],
                'main_table.id = mp.manufacturer_id',
                ['product_id']
            )
            ->where('mp.product_id IN (?)', $productIdsArray);

        $manufacturerProductArray = [];

        foreach ($manufacturerCollection->getData() as $manufacturer) {
            $manufacturerProductArray[$manufacturer['product_id']] = $manufacturer['name'];
        }

        return $manufacturerProductArray;
    }

    public function getManufacturerByImportedManufacturer(
        ImportedManufacturer $importedManufacturerModel) : Manufacturer
    {
        $manufacturerModel = $this->manufacturerFactory->create();

        $this->manufacturerResourceModel->load(
            $manufacturerModel,
            $importedManufacturerModel->getData('client_manufacturer_id')
        );

        return $manufacturerModel;
    }
    
    public function getManufacturersWithAttributeOptionId() : ManufacturerResourceModel\Collection
    {
        return $this->manufacturerFactory
            ->create()
            ->getCollection()
            ->addFieldToFilter('attribute_option_id', ['notnull' => true])
            ->setOrder('name', 'ASC')
            ->join(
                ['bim' => 'bridge_imported_manufacturer'], 
                'bim.client_manufacturer_id = main_table.id AND bim.is_selected = 1', 
                []
            );
    }

    public function save(Manufacturer $manufacturer)
    {
        $manufacturer->getResource()->save($manufacturer);
    }
}
