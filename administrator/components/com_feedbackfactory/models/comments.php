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

class BackendModelComments extends JModelLegacy
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

    $query = ' SELECT c.*, IF (c.user_id != 0, u.username, "Guest") AS username, f.title as feedback_title '
           . ' FROM #__feedback_comments c'
           . ' LEFT JOIN #__users u ON u.id = c.user_id'
           . ' LEFT JOIN #__feedback_feedbacks f ON f.id = c.feedback_id'
           . $where
           . $orderby;

    return $query;
  }

  function _buildContentOrderBy()
  {
    $mainframe = JFactory::getApplication();
    $option = 'com_feedbackfactory';

    $filter_order     = $mainframe->getUserStateFromRequest($option . '.comments.filter_order',     'filter_order',     'title', 'cmd');
    $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.comments.filter_order_Dir', 'filter_order_Dir', 'asc',   'word');

    $orderby = '';

    if (in_array($filter_order, array('c.comment', 'f.title', 'c.date_added')))
    {
      $orderby = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;
    }

    return $orderby;
  }

  function _buildContentWhere()
  {
    $mainframe = JFactory::getApplication();
    $option = 'com_feedbackfactory';

    $search   = $mainframe->getUserStateFromRequest($option . '.comments.search',       'search',       '', 'cmd');
    $state    = $mainframe->getUserStateFromRequest($option . '.comments.filter_state', 'filter_state', '', 'cmd');

    $where = ' WHERE 1';

    if ($search != '')
    {
      $where .= ' AND c.comment LIKE "%' . $search . '%"';
    }

    return $where;
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
