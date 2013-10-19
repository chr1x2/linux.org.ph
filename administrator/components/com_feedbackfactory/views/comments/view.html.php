<?php
/*------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 2.0.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class BackendViewComments extends JViewLegacy
{
  function display($tpl = null)
  {
    JToolBarHelper::title(JText::_('Comments'), 'generic.png');

    JToolBarHelper::spacer();
    JToolBarHelper::editList();
    JToolBarHelper::deleteList(JText::_('Are you sure?'));

    $comments   =& $this->get('Data');
    $pagination =& $this->get('Pagination');
    $lists      =& $this->_getViewLists();

    $this->assignRef('comments',   $comments);
    $this->assignRef('pagination', $pagination);
    $this->assignRef('lists',      $lists);

    parent::display($tpl);
  }

  function &_getViewLists()
  {
	$mainframe = JFactory::getApplication();
	$option = 'com_feedbackfactory';

	$filter_order     	= $mainframe->getUserStateFromRequest($option . '.comments.filter_order',     	'filter_order',     'title', 'cmd');
    $filter_order_Dir 	= $mainframe->getUserStateFromRequest($option . '.comments.filter_order_Dir', 	'filter_order_Dir', 'asc',   'word');
    $search				= $mainframe->getUserStateFromRequest($option . '.comments.search',			    'search',			'',		 'string');
	$search				= JString::strtolower($search);

	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		  = $filter_order;

	// search
	$lists['search'] = $search;

	return $lists;
  }
}
