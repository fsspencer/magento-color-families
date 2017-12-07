<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();


/**
 * Create codealist_color_family_entity table.
 */
$colorFamilyEntityTable = $installer->getTable('codealist_colorfamilies/entity');
if ($installer->getConnection()->isTableExists($colorFamilyEntityTable)) {
    $installer->getConnection()->dropTable($colorFamilyEntityTable);
}

$table = $installer->getConnection()->newTable($colorFamilyEntityTable)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'primary'  => true,
        'identity' => true,
        'unsigned' => true,
        'nullable' => false
    ), 'ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
       'nullable'  => false,
    ), 'Name');
$installer->getConnection()->createTable($table);


$installer->endSetup();