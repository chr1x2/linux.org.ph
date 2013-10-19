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

class BackendViewFeedbacks extends JViewLegacy
{
  function display($tpl = null)
  {
    JToolBarHelper::title(JText::_('Feedbacks list'), 'levels.png');

    //$bar =& JToolBar::getInstance('toolbar');
    JToolBarHelper::custom('changex', 'move.png', 'move.png', JText::_('FEEDBACKS_CHANGE_CATEGORY'));
    JToolBarHelper::custom('changestatus', 'apply.png', 'apply.png', JText::_('FEEDBACKS_CHANGE_STATUS'));

    JToolBarHelper::spacer();
    JToolBarHelper::addNew();
    JToolBarHelper::editList();
    JToolBarHelper::deleteList(JText::_('Are you sure?'));
    
    $feedbacks  =& $this->get('Data');
    $pagination =& $this->get('Pagination');
    $lists      =& $this->_getViewLists();
    $categories =& $this->get('Categories');
    $statuses	=& $this->get('Statuses');
    
    $this->assignRef('feedbacks',      	$feedbacks);
    $this->assignRef('pagination', 		$pagination);
    $this->assignRef('lists',      		$lists);
    
    $this->assignRef('categories',      $categories);
    $this->assignRef('statuses',      $statuses);
     
        // Javascripts
      $document = JFactory::getDocument();
      $document->addScript(JUri::root().'media/system/js/modal.js');
      //$document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/jquery.noconflict.js');

      // Stylesheets
      $document->addStyleSheet(JUri::root().'media/system/css/modal.css');

    
    parent::display($tpl);
  }
  
  function &_getViewLists()
  {
	$mainframe = JFactory::getApplication();
	$option = 'com_feedbackfactory';

	$filter_order     	= $mainframe->getUserStateFromRequest($option . '.feedbacks.filter_order',     	'filter_order',     'title', 	'cmd');
    $filter_order_Dir 	= $mainframe->getUserStateFromRequest($option . '.feedbacks.filter_order_Dir', 	'filter_order_Dir', 'asc',   	'word');
    $search				= $mainframe->getUserStateFromRequest($option . '.feedbacks.search',			'search',			 '',		'string');
	$search				= JString::strtolower($search);
	$category 			= $mainframe->getUserStateFromRequest($option . '.feedbacks.category_filter',	'category_filter',		 '',		'int');
	
	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;

	// search
	$lists['search'] = $search;
		
	// categories
	$lists['category_filter'] = $category;

	return $lists;
  }
  
}
     
