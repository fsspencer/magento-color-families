<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();


/**
 * Create codealist_color_family_value table.
 */
$colorFamilyValuesTable = $installer->getTable('codealist_colorfamilies/value');
if ($installer->getConnection()->isTableExists($colorFamilyValuesTable)) {
    $installer->getConnection()->dropTable($colorFamilyValuesTable);
}

$table = $installer->getConnection()->newTable($colorFamilyValuesTable)
    ->addColumn('color_family_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false
    ), 'Color Family ID')
    ->addColumn('color_option_value', Varien_Db_Ddl_Table::TYPE_INTEGER, 0, array(
        'nullable'  => false,
    ), 'Color Option Value')
    ->addForeignKey($installer->getFkName($colorFamilyValuesTable, 'color_family_id', 'codealist_color_family_entity', 'id'),
        'color_family_id', $installer->getTable('codealist_colorfamilies/entity'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);


$installer->endSetup();