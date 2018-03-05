<?php

namespace Powerbody\Manufacturer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 * @package Powerbody\Manufacturer\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('manufacturer'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,]
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false,]
            )->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true,]
            )->addColumn(
                'logo',
                Table::TYPE_TEXT,
                50,
                ['nullable' => true,]
            )->addColumn(
                'logo_normal',
                Table::TYPE_TEXT,
                50,
                ['nullable' => true,]
            )->addColumn(
                'priority',
                Table::TYPE_INTEGER,
                10,
                ['nullable' => true, 'unsigned' => true,]
            )->addColumn(
                'brand_to_withdraw',
                Table::TYPE_SMALLINT,
                1,
                ['nullable' => true, 'default' => 0, 'unsigned' => true,]
            )->addColumn(
                'is_visible_on_front',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => 1, 'unsigned' => true,]
            )->addColumn(
                'base_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false,]
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT]
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE]
            );
        $setup->getConnection()->createTable($table);
    }
}
