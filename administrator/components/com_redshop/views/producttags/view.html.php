<?php
/**
 * @package     redSHOP
 * @subpackage  Views
 *
 * @copyright   Copyright (C) 2008 - 2012 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class producttagsViewproducttags extends JView
{
    function display($tpl = null)
    {
        global $mainframe, $context;
        $context  = 't.tags_id';
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_REDSHOP_TAGS'));

        JToolBarHelper::title(JText::_('COM_REDSHOP_TAGS_MANAGEMENT'), 'redshop_textlibrary48');

        JToolBarHelper::editListX();
        JToolBarHelper::deleteList();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();

        $uri = JFactory::getURI();

        $filter_order     = $mainframe->getUserStateFromRequest($context . 'filter_order', 'filter_order', 'tags_id');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', '');

        $lists['order']     = $filter_order;
        $lists['order_Dir'] = $filter_order_Dir;
        $tags               = $this->get('Data');
        $pagination         = $this->get('Pagination');

        $this->user = JFactory::getUser();
        $this->assignRef('lists', $lists);
        $this->assignRef('tags', $tags);
        $this->assignRef('pagination', $pagination);
        $this->request_url = $uri->toString();
        parent::display($tpl);
    }
}
