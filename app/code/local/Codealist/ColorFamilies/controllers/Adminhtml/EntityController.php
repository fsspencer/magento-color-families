<?php

class Codealist_ColorFamilies_Adminhtml_EntityController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Instantiate our grid container block and add to the page content.
     * When accessing this admin index page, we will see a grid of all
     * entities currently available in our Magento instance, along with
     * a button to add a new one if we wish.
     */
    public function indexAction()
    {
        // instantiate the grid container
        $entityBlock = $this->getLayout()
            ->createBlock('codealist_colorfamilies_adminhtml/entity');

        // Add the grid container as the only item on this page
        $this->loadLayout()
            ->_addContent($entityBlock)
            ->renderLayout();
    }

    /**
     * This action handles both viewing and editing existing entities.
     */
    public function editAction()
    {
        /**
         * Retrieve existing entity data if an ID was specified.
         * If not, we will have an empty entity entity ready to be populated.
         */
        $entity = Mage::getModel('codealist_colorfamilies/entity');
        if ($entityId = $this->getRequest()->getParam('id', false)) {
            $entity->load($entityId);

            if (!$entity->getId()) {
                Mage::getSingleton('core/session')->addError(
                    $this->__('This color family no longer exists.')
                );
                return $this->_redirect(
                    'codealist_colorfamilies_admin/entity/index'
                );
            }
        }

        // process $_POST data if the form was submitted

        if ($postData = $this->getRequest()->getPost('entityData')) {
            try {
                $entity->addData($postData);
                $entity->save();

                $this->_getSession()->addSuccess(
                    $this->__('The color family has been saved.')
                );

                // redirect to remove $_POST data from the request
                return $this->_redirect('*/*/edit', array('id' => $entity->getId()));
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }

            /**
             * If we get to here, then something went wrong. Continue to
             * render the page as before, the difference this time being
             * that the submitted $_POST data is available.
             */
        }

        // Make the current entity object available to blocks.
        Mage::register('current_entity', $entity);

        // Instantiate the form container.
        $entityEditBlock = $this->getLayout()->createBlock(
            'codealist_colorfamilies_adminhtml/entity_edit'
        );

        // Add the form container as the only item on this page.
        $this->loadLayout()
            ->_addContent($entityEditBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $entity = Mage::getModel('codealist_colorfamilies/entity');

        if ($entityId = $this->getRequest()->getParam('id', false)) {
            $entity->load($entityId);
        }

        if (!$entity->getId()) {
            Mage::getSingleton('core/session')->addError(
                $this->__('This color family no longer exists.')
            );
            return $this->_redirect(
                'codealist_colorfamilies_admin/entity/index'
            );
        }

        try {
            $entity->delete();

            $this->_getSession()->addSuccess(
                $this->__('The color family has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'codealist_colorfamilies_admin/entity/index'
        );
    }

    /**
     * Thanks to Ben for pointing out this method was missing. Without
     * this method the ACL rules configured in adminhtml.xml are ignored.
     */
    protected function _isAllowed()
    {
        /**
         * we include this switch to demonstrate that you can add action
         * level restrictions in your ACL rules. The isAllowed() method will
         * use the ACL rule we have configured in our adminhtml.xml file:
         * - acl
         * - - resources
         * - - - admin
         * - - - - children
         * - - - - - codealist_colorfamilies
         * - - - - - - children
         * - - - - - - - entity
         *
         * eg. you could add more rules inside entity for edit and delete.
         */
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
                // intentionally no break
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('codealist_colorfamilies/entity');
                break;
        }

        return $isAllowed;
    }

}