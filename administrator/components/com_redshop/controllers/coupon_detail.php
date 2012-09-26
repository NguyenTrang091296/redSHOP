<?php
/**
 * @package     redSHOP
 * @subpackage  Controllers
 *
 * @copyright   Copyright (C) 2008 - 2012 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'core' . DS . 'controller.php';

class coupon_detailController extends RedshopCoreController
{
    public function __construct($default = array())
    {
        parent::__construct($default);
        $this->registerTask('add', 'edit');
    }

    public function edit()
    {
        $this->input->set('view', 'coupon_detail');
        $this->input->set('layout', 'default');
        $this->input->set('hidemainmenu', 1);

        $model     = $this->getModel('coupon_detail');
        $userslist = $model->getuserslist();
        $this->input->set('userslist', $userslist);

        $product = $model->getproducts();
        $this->input->set('product', $product);

        parent::display();
    }

    public function save()
    {
        $post            = $this->input->get('post');
        $post["comment"] = $this->input->post->getString('comment', '');

        $option = $this->input->get('option');

        $cid = $this->input->post->get('cid', array(0), 'array');

        $post ['coupon_id']  = $cid [0];
        $post ['start_date'] = strtotime($post ['start_date']);

        if ($post ['end_date'])
        {
            $post ['end_date'] = strtotime($post ['end_date']) + (23 * 59 * 59);
        }

        $model = $this->getModel('coupon_detail');

        if ($post['old_coupon_code'] != $post['coupon_code'])
        {
            if ($model->checkduplicate($post['coupon_code']))
            {
                $msg = JText::_('COM_REDSHOP_CODE_IS_ALREADY_IN_USE');
                $this->app->redirect('index.php?option=' . $option . '&view=coupon_detail&task=edit&cid=' . $post ['coupon_id'], $msg);
            }
        }

        if ($model->store($post))
        {

            $msg = JText::_('COM_REDSHOP_COUPON_DETAIL_SAVED');
        }
        else
        {

            $msg = JText::_('COM_REDSHOP_ERROR_SAVING_COUPON_DETAIL');
        }

        $this->setRedirect('index.php?option=' . $option . '&view=coupon', $msg);
    }

    public function remove()
    {
        $option = $this->input->get('option');

        $cid = $this->input->post->get('cid', array(0), 'array');

        if (!is_array($cid) || count($cid) < 1)
        {
            JError::raiseError(500, JText::_('COM_REDSHOP_SELECT_AN_ITEM_TO_DELETE'));
        }

        $model = $this->getModel('coupon_detail');

        if (!$model->delete($cid))
        {
            echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
        }

        $msg = JText::_('COM_REDSHOP_COUPON_DETAIL_DELETED_SUCCESSFULLY');
        $this->setRedirect('index.php?option=' . $option . '&view=coupon', $msg);
    }

    public function publish()
    {
        $option = $this->input->get('option');

        $cid = $this->input->post->get('cid', array(0), 'array');

        if (!is_array($cid) || count($cid) < 1)
        {
            JError::raiseError(500, JText::_('COM_REDSHOP_SELECT_AN_ITEM_TO_PUBLISH'));
        }

        $model = $this->getModel('coupon_detail');

        if (!$model->publish($cid, 1))
        {
            echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
        }

        $msg = JText::_('COM_REDSHOP_COUPON_DETAIL_PUBLISHED_SUCCESFULLY');
        $this->setRedirect('index.php?option=' . $option . '&view=coupon', $msg);
    }

    public function unpublish()
    {
        $option = $this->input->get('option');

        $cid = $this->input->post->get('cid', array(0), 'array');

        if (!is_array($cid) || count($cid) < 1)
        {
            JError::raiseError(500, JText::_('COM_REDSHOP_SELECT_AN_ITEM_TO_UNPUBLISH'));
        }

        $model = $this->getModel('coupon_detail');

        if (!$model->publish($cid, 0))
        {
            echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
        }

        $msg = JText::_('COM_REDSHOP_COUPON_DETAIL_UNPUBLISHED_SUCCESFULLY');
        $this->setRedirect('index.php?option=' . $option . '&view=coupon', $msg);
    }

    public function cancel()
    {
        $option = $this->input->get('option');

        $msg = JText::_('COM_REDSHOP_COUPON_DETAIL_EDITING_CANCELLED');
        $this->setRedirect('index.php?option=' . $option . '&view=coupon', $msg);
    }
}
