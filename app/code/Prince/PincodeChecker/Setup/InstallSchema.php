<?php


namespace Prince\PincodeChecker\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table_prince_pincodechecker = $setup->getConnection()->newTable($setup->getTable('prince_pincodechecker'));

        
        $table_prince_pincodechecker->addColumn(
            'pincode_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Pincode ID'
        );
        

        
        $table_prince_pincodechecker->addColumn(
            'pincode',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'pincode'
        );
        

        $setup->getConnection()->createTable($table_prince_pincodechecker);

        $setup->endSetup();

        /* Create new pincode text attribute of product */

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'pincode',
            [
                'type' => 'varchar',
                'backend' => '',
                'frontend' => '',
                'label' => 'Exclude Pin code',
                'input' => 'text',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );

    }
}
