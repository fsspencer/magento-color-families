<?php


class Codealist_ColorFamilies_Model_Mysql4_Entity_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Indicates which is the original Model for this collection
     * in order to render each item of the collection
     */
    protected function _construct()
    {
        $this->_init('codealist_colorfamilies/entity');
    }
}