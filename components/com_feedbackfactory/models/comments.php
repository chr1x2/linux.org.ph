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

class FrontendModelComments extends JModelLegacy
{
  var $_data;
  var $_total;
  var $_pagination;
  var $_limit;
  var $_limitstart;

  function __construct()
  {
    parent::__construct();

    $this->feedbackSettings = new feedbackSettings();

    $app = JFactory::getApplication();
    $option = 'com_feedbackfactory';

    $this->_limit      = $app->getUserStateFromRequest('global.list.limit', 'limit', $this->feedbackSettings->comments_per_page, 'int');
    $this->_limitstart = $app->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

    $this->_limitstart = ($this->_limit != 0 ? (floor($this->_limitstart / $this->_limit) * $this->_limit) : 0);
  }

  function getData()
  {
    if (empty($this->_data))
    {
      $query = $this->_buildQuery();
      $this->_data = $this->_getList($query, $this->_limitstart, $this->_limit);
    }

    return $this->_data;
  }

  function _buildQuery()
  {
      $app = JFactory::getApplication();
      $feedback_id = $app->input->getInt('feedback_id', 0);

    $user    = JFactory::getUser();
   
    $query = ' SELECT c.*, IF(u.username IS NOT NULL, u.username, "' . JText::_('Anonymous') . '") AS username'
           . ' FROM #__feedback_comments c'
           . ' LEFT JOIN #__users u ON u.id = c.user_id'
           . ' WHERE c.feedback_id = ' . $feedback_id
           . ' ORDER BY c.date_added DESC'; 

     return $query;
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
      $this->_pagination = new JPagination($this->getTotal(), $this->_limitstart, $this->_limit);
    }

    return $this->_pagination;
  }

  function getFeedback()
  {
    $feedback_id = JFactory::getApplication()->input->getInt('feedback_id', 0);

    $query = ' SELECT f.id, f.user_id, f.enable_cb_avatar, IF(u.username IS NOT NULL, u.username, "' . JText::_('Anonymous') . '") AS username'
           . ' FROM #__feedback_feedbacks f'
           . ' LEFT JOIN #__users u ON u.id = f.user_id'
           . ' WHERE f.id = '.$feedback_id; 

    $this->_db->setQuery($query);
    $feedback = $this->_db->loadObject();
    return $feedback;

  }
  
}
  

