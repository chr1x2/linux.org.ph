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

class BackendViewStatuses extends JViewLegacy
{
  function display($tpl = null)
  {
    JToolBarHelper::title(JText::_('Statuses'), 'sections.png');

    $bar =& JToolBar::getInstance('toolbar');

    JToolBarHelper::publishList();
    JToolBarHelper::unpublishList();
    JToolBarHelper::spacer();
    JToolBarHelper::addNew();
    JToolBarHelper::editList();
    JToolBarHelper::deleteList(JText::_('Are you sure?'));
    
    $statuses      =& $this->get('Data');
    $pagination =& $this->get('Pagination');
    $lists      =& $this->_getViewLists();

    $this->assignRef('statuses',      $statuses);
    $this->assignRef('pagination', $pagination);
    $this->assignRef('lists',      $lists);
     
    // Javascripts
    //JHTML::script('modal.js',	'media/system/js/');
    $document = JFactory::getDocument();
    $document->addScript(JUri::root().'media/system/js/modal.js');

    // Stylesheets
    $document->addStyleSheet(JUri::root().'media/system/css/modal.css');
    
    parent::display($tpl);
  }
  
  function &_getViewLists()
  {
	$mainframe = JFactory::getApplication();
	$option = 'com_feedbackfactory';

	$filter_order     	= $mainframe->getUserStateFromRequest($option . '.statuses.filter_order',     	'filter_order',     'title', 	'cmd');
    $filter_order_Dir 	= $mainframe->getUserStateFromRequest($option . '.statuses.filter_order_Dir', 	'filter_order_Dir', 'asc',   	'word');
    $filter_state		= $mainframe->getUserStateFromRequest($option . '.statuses.filter_state',		'filter_state',		 '',		'word');
    $search				= $mainframe->getUserStateFromRequest($option . '.statuses.search',			'search',			 '',		'string');
	$search				= JString::strtolower($search);

	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;

	// search
	$lists['search'] = $search;

	// state
	$lists['state'] = $filter_state;

	return $lists;
  }
  
}
     
