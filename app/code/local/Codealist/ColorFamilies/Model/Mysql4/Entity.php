<?php

class Codealist_ColorFamilies_Model_Mysql4_Entity extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Specifies the database table for this resource model
     */
    protected function _construct()
    {
        $this->_init('codealist_colorfamilies/entity', 'id');
    }
}