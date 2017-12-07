<?php

class Codealist_ColorFamilies_Block_Adminhtml_Entity_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // Instantiate a new form to display our entity for editing.
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'codealist_colorfamilies_admin/entity/edit',
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method' => 'post',
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        // Define a new fieldset. We need only one for our simple entity.
        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Color Family Details')
            )
        );

        $entitySingleton = Mage::getSingleton(
            'codealist_colorfamilies/entity'
        );

        $objectModel = Mage::registry('current_entity');

        // Add the fields that we want to be editable.
        $this->_addFieldsToFieldset($fieldset, array(
            'name' => array(
                'label' => $this->__('Name'),
                'input' => 'text',
                'required' => true,
            ),

            /**
             * Note: we have not included created_at or updated_at.
             * We will handle those fields ourself in the model
             * before saving.
             */

            'color_values' => array(
                'label' => $this->__('Colors'),
                'input' => 'multiselect',
                'required' => true,
                'values' => Mage::helper('codealist_colorfamilies/data')->getColorValues(),
                'value' => $objectModel->getColorValues()
            )
        ));

        return $this;
    }

    /**
     * This method makes life a little easier for us by pre-populating
     * fields with $_POST data where applicable and wrapping our post data
     * in 'entityData' so that we can easily separate all relevant information
     * in the controller. You could of course omit this method entirely
     * and call the $fieldset->addField() method directly.
     */
    protected function _addFieldsToFieldset(
        Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('entityData'));

        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }

            // Wrap all fields with entityData group.
            $_data['name'] = "entityData[$name]";

            // Generally, label and title are always the same.
            $_data['title'] = $_data['label'];

            // If no new value exists, use the existing entity data.
            if (!array_key_exists('value', $_data)) {
                $_data['value'] = $this->_getEntity()->getData($name);
            }

            // Finally, call vanilla functionality to add field.
            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    /**
     * Retrieve the existing entity for pre-populating the form fields.
     * For a new entity entry, this will return an empty entity object.
     */
    protected function _getEntity()
    {
        if (!$this->hasData('entity')) {
            // This will have been set in the controller.
            $entity = Mage::registry('current_entity');

            // Just in case the controller does not register the entity.
            if (!$entity instanceof
                Codealist_ColorFamilies_Model_Entity) {
                $entity = Mage::getModel(
                    'codealist_colorfamilies/entity'
                );
            }

            $this->setData('entity', $entity);
        }

        return $this->getData('entity');
    }
}