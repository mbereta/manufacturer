<?php

namespace Powerbody\Manufacturer\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $this->install102($setup);
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $this->install103($setup);
        }

        if (version_compare($context->getVersion(), '1.0.4') < 0) {
            $this->install104($setup);
        }

        if (version_compare($context->getVersion(), '1.0.6', '<')) {
            $this->install106($setup);
        }

        $setup->endSetup();
    }

    private function install102(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable('manufacturer');

        if (true === $setup->getConnection()
                ->isTableExists($tableName) && true === $setup->getConnection()
                ->tableColumnExists($tableName, 'base_id')
        ) {
            $connection = $setup->getConnection();
            $connection->changeColumn(
                $tableName, 'base_id', 'margin', [
                'type' => Table::TYPE_INTEGER,
                'nullable' => false,
                'default' => 0
            ], 'Margin');
        }
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function install103(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable('manufacturer_product');
        if (true !== $setup->getConnection()
                ->isTableExists($tableName)
        ) {
            $connection = $setup->getConnection();
            $table = $connection->newTable($tableName)
                ->addColumn(
                    'id', Table::TYPE_INTEGER, null, [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                ])
                ->addColumn(
                    'product_id', Table::TYPE_INTEGER, null, [
                    'nullable' => false,
                    'unsigned' => true,
                ])
                ->addColumn(
                    'manufacturer_id', Table::TYPE_INTEGER, null, [
                    'nullable' => false,
                    'unsigned' => true,
                ])
                ->addForeignKey(
                    $connection->getForeignKeyName(
                        $tableName, 'product_id', $connection->getTableName('catalog_product_entity'), 'entity_id'
                    ), 'product_id', $connection->getTableName('catalog_product_entity'), 'entity_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $connection->getForeignKeyName(
                        $tableName, 'manufacturer_id', $connection->getTableName('manufacturer'), 'id'
                    ), 'manufacturer_id', $connection->getTableName('manufacturer'), 'id', Table::ACTION_CASCADE
                )
            ;
            $connection->createTable($table);
        }
    }

    private function install104(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable('manufacturer');
        $connection = $setup->getConnection();
        if (true === $connection->isTableExists($tableName)) {
            if (false === $connection->tableColumnExists($tableName, 'margin')) {
                $connection->addColumn(
                    $tableName,
                    'margin',
                    [
                        'type' => Table::TYPE_FLOAT,
                        'nullable' => false,
                        'unsigned' => true,
                        'comment' => 'Margin',
                    ]
                );
            }
        }
    }

    private function install106(SchemaSetupInterface $setup)
    {
        $manufacturerTableName = $setup->getTable('manufacturer');

        if (true === $setup->getConnection()->isTableExists($manufacturerTableName)) {
            $setup->getConnection()
                ->addColumn(
                    $manufacturerTableName,
                    'attribute_option_id',
                    [
                        'type' => Table::TYPE_INTEGER,
                        'nullable' => true,
                        'default' => null,
                        'after' => 'margin',
                        'comment' => 'Manufacturer attribute option ID'
                    ]
                );
        }
    }

}
