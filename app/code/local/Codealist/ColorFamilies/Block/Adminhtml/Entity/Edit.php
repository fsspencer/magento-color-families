<?php


class Codealist_ColorFamilies_Block_Adminhtml_Entity_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'codealist_colorfamilies_adminhtml';
        $this->_controller = 'entity';

        /**
         * The $_mode property tells Magento which folder to use
         * to locate the related form blocks to be displayed in
         * this form container. In our example, this corresponds
         * to Codealist/ColorFamilies/Block/Adminhtml/Entity/Edit/.
         */
        $this->_mode = 'edit';

        $newOrEdit = $this->getRequest()->getParam('id')
            ? $this->__('Edit')
            : $this->__('New');
        $this->_headerText =  $newOrEdit . ' ' . $this->__('Color Family');
    }
}