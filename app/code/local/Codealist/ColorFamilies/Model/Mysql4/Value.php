<?php

class Codealist_ColorFamilies_Model_Mysql4_Value extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Specifies the database table for this resource model
     */
    protected function _construct()
    {
        $this->_init('codealist_colorfamilies/value', null);
    }

    /**
     * Mass Delete action to remove all the
     * associated colors to a color family
     *
     * @param $colorFamilyId
     */
    public function massDelete($colorFamilyId)
    {
        $resourceConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $resourceConnection->delete(Mage::getSingleton('core/resource')->getTableName('codealist_colorfamilies/value'),
            array('color_family_id' => $colorFamilyId));
    }
}