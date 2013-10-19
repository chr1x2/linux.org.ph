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

jimport('joomla.application.component.model');

class BackendModelFeedbacks extends JModelLegacy
{
  var $_data;
  var $_total;
  var $_pagination;

  function __construct()
  {
	parent::__construct();
		
	$mainframe = JFactory::getApplication();
	$option = 'com_feedbackfactory';
	
	$limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
    $limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

    $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

    $this->setState('limit', $limit);
    $this->setState('limitstart', $limitstart);
  }
  
  function getData()
  {
    if (empty($this->_data))
    {
      $query = $this->_buildQuery();
      $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
    }

    return $this->_data;
  }

  function _buildQuery()
  {
    $orderby = $this->_buildContentOrderBy();
    $where   = $this->_buildContentWhere();

    $query = ' SELECT f.*, f.user_id, IF (f.user_id != 0, u.username, "Guest") AS username, s.status, c.title as category_title, f.hits '
           . ' FROM #__feedback_feedbacks f'
           . ' LEFT JOIN #__users u ON u.id = f.user_id'
           . ' LEFT JOIN #__feedback_statuses s ON s.id = f.status_id'
           . ' LEFT JOIN #__feedback_categories c ON c.id = f.category_id'
           . $where
           . $orderby;

    return $query;
  }

  function _buildContentOrderBy()
  {
    $mainframe = JFactory::getApplication();
    $option = 'com_feedbackfactory';
    
    $filter_order     = $mainframe->getUserStateFromRequest($option . '.feedbacks.filter_order',     'filter_order',     'f.date_created', 'cmd');
    $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.feedbacks.filter_order_Dir', 'filter_order_Dir', 'desc',   'word');
    
    $orderby = '';

    if (in_array($filter_order, array('f.title', 'f.date_created', 'f.date_updated', 's.status','c.title', 'username', 'f.hits')))
    {
      $orderby = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;
    }

    return $orderby;
  }
  
  //filters
  function _buildContentWhere()
  {
    $mainframe = JFactory::getApplication();
    $option = 'com_feedbackfactory';

    $search 	= $mainframe->getUserStateFromRequest($option . '.feedbacks.search',       		'search',       	'', 'cmd');
    $category  	= $mainframe->getUserStateFromRequest($option . '.feedbacks.category_filter', 	'category_filter', 	'', 'int');

    $where = ' WHERE 1';

    if ($search != '')
    {
      $where .= ' AND f.title LIKE "%' . $search . '%"';
    }
    
    if ($category != 0)
    {
      $where .= ' AND f.category_id = ' . $category;
    }

    return $where;
  }
  
  function getCategories()
  {
  	$query = ' SELECT c.* '
           . ' FROM #__feedback_categories c'
           . ' WHERE c.published = 1'
           . ' ORDER BY c.title ASC';
    
    $this->_db->setQuery($query);
	$categories= $this->_db->loadAssocList();

	return $categories;
  }

  function getStatuses()
  {
  	$query = ' SELECT s.* '
           . ' FROM #__feedback_statuses s'
           . ' WHERE s.published = 1'
           . ' ORDER BY s.status ASC';
    
    $this->_db->setQuery($query);
	$statuses= $this->_db->loadAssocList();

	return $statuses;
  }

  
  function getTotal()
  {
    if (empty($this->_total))
    {
      $query = $this->_buildQuery();
      $this->_total = $this->_getListCount($query);
    }

    return $this->_total;
  }

  function getPagination()
  {
    if (empty($this->_pagination))
    {
      jimport('joomla.html.pagination');
      $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
    }

    return $this->_pagination;
  }

  
}
