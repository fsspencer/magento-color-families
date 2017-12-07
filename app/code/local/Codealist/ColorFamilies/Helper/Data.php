<?php

class Codealist_ColorFamilies_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Returns all the options for the product attribute "color"
     *
     * @return array
     */
    public function getColorValues()
    {
        $attribute = Mage::getSingleton('eav/config')
            ->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'color'); // color is the attribute code here

        $options = array();

        if ($attribute->usesSource()) {
            $options = $attribute->getSource()->getAllOptions(false);
        }

        return $options;
    }

}