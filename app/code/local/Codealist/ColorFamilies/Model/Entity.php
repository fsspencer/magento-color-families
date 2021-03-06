<?php

class Codealist_ColorFamilies_Model_Entity extends Mage_Core_Model_Abstract
{
    /**
     * Indicates which one is the resource model
     * for this model
     */
    protected function _construct()
    {
        $this->_init('codealist_colorfamilies/entity');
    }

    /**
     * Returns the color values for the product attribute "color"
     *
     * @return array
     */
    public function getColorValues()
    {
        $values = Mage::getModel('codealist_colorfamilies/value')->getCollection()
            ->addFieldToFilter('color_family_id', $this->getId())
            ->addFieldToSelect('color_option_value')
            ->load()
            ->getData();

        $result = array();
        foreach ($values as $v) {
            $result[] = $v['color_option_value'];
        }
        return $result;
    }

    /**
     * After the Color Family is saved
     * I will clear all the color value associations
     * and associate the new options
     *
     * @return Mage_Core_Model_Abstract
     */
    public function _afterSave()
    {
        $colorValuesPostData = $this->getData('color_values');
        if ($colorValuesPostData && is_array($colorValuesPostData)) {
            $valuesCollection = Mage::getModel('codealist_colorfamilies/value')->getResource()
                ->massDelete($this->getId());

            foreach ($colorValuesPostData as $v) {
                $colorValueObject = Mage::getModel('codealist_colorfamilies/value');
                $colorValueObject->setData('color_family_id', $this->getId());
                $colorValueObject->setData('color_option_value', $v);
                $colorValueObject->save();
            }
        }
        return parent::_afterSave(); // TODO: Change the autogenerated stub
    }
}