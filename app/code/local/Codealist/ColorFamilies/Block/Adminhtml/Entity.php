<?php


class Codealist_ColorFamilies_Block_Adminhtml_Entity extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct(); // TODO: Change the autogenerated stub

        /**
         * The $_blockGroup property tells Magento which alias to use to
         * locate the blocks to be displayed in this grid container.
         * In our example, this corresponds to Codealist/ColorFamilies/Block/Adminhtml.
         */
        $this->_blockGroup = 'codealist_colorfamilies_adminhtml';

        /**
         * $_controller is a slightly confusing name for this property.
         * This value, in fact, refers to the folder containing our
         * Grid.php and Edit.php - in our example,
         * Codealist/ColorFamilies/Block/Adminhtml/Entity. So, we'll use 'entity'.
         */
        $this->_controller = 'entity';

        /**
         * The title of the page in the admin panel.
         */
        $this->_headerText = Mage::helper('codealist_colorfamilies')
            ->__('Manage Color Families');
    }

    public function getCreateUrl()
    {
        return $this->getUrl(
            'codealist_colorfamilies_admin/entity/edit'
        );
    }
}