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

class FrontendModelAccepted extends JModelLegacy
{
  var $parameters;
  var $conditions = array();
  var $limitstart;
  var $status;
  var $feedbacks_per_page;
  var $_pagination_pending;
  var $_pagination_planned;
  var $_pagination_started;
  var $_total_pending;
  var $_total_planned;
  var $_total_started;
  var $settings;

  function __construct()
  {
    $this->settings = new feedbackSettings();
    $this->feedbacks_per_page = ($this->settings->feedbacks_per_page != 0) ? $this->settings->feedbacks_per_page : 10;
      $app = JFactory::getApplication();
      $option = 'com_feedbackfactory';
      $this->limitstart = $app->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
      $this->limit      = $app->getUserStateFromRequest('global.list.limit', 'limit', $this->feedbacks_per_page, 'int');

      $this->limitstart = ($this->limit != 0 ? (floor($this->limitstart / $this->limit) * $this->limit) : 0);

    parent::__construct();
  }
 
  function setParameters($parameters)
  {
    $this->parameters = $parameters;
  }

  function getParameters()
  {
    return $this->parameters;
  }
    
  function getStatusId($status)
  {
  	$database = JFactory::getDBO();
  	$query = ' SELECT id '
  		. ' FROM #__feedback_statuses '
  		. ' WHERE status ="'.$status.' "';
  		
  	$database->setQuery($query);
  	return $database->loadResult();
  			  	
  }

  function _buildQuery($status)
  {
  	$this->setConditions($status);
    
    $query = $this->getQuery();
    #var_dump(str_replace('#__', 'jos_', $query));

    return $query;
  }
    
  function getQuery()
  {
  	$default_search = ( ($this->parameters['search_type'] != 0)) ? $this->getSearch() : '';
  	
  	$query = ' SELECT DISTINCT f.*, IF (f.user_id != 0, u.username, "Guest") AS username, IF(f.hits != null, f.hits, 0) as hits, c.title as category_title, s.status '
    	   . ' ,(SELECT COUNT(m.id) from #__feedback_comments m WHERE m.feedback_id = f.id ) AS no_comments '
    	   //. ',"accepted" as type'
    	   . ' ,"'.$this->status.'" as type '
           . ' FROM #__feedback_feedbacks f'
           . ' LEFT JOIN #__users u ON f.user_id = u.id'
           . ' LEFT JOIN #__feedback_votes v ON v.feedback_id = f.id '
           . ' LEFT JOIN #__feedback_categories c ON c.id = f.category_id '
           . ' LEFT JOIN #__feedback_statuses s ON s.id = f.status_id '
           . ' LEFT JOIN #__feedback_comments m ON m.feedback_id = f.id '
           . ' WHERE s.published = 1'
           . ' AND c.published = 1'
           . $this->conditions
           . $default_search
           . ' ORDER BY date_created DESC';
            
    return $query;
  }
  
  function getSearch() {
  	
  	$default_search = ' AND ( ' . $this->getSearchConditionsTitle()
            . ' OR '    . $this->getSearchConditionsDescription()
            . ' OR '    . $this->getSearchConditionsCategory() .' )';

    return $default_search;
  }

  function setConditions($status)
  {
  	switch ($status)
    {
      case 'pending':
	    $status_id = $this->getStatusId('Accepted pending');
        break;

      case 'started':
        $status_id = $this->getStatusId('Accepted started');
        break;

      case 'planned':
        $status_id = $this->getStatusId('Accepted planned');
        break;
      
      default:
      	$default_search = '';
      	$status_id = $this->getStatusId('Accepted pending');
      	break;
      
    }

    $conditions = ' AND f.status_id = ' . $status_id;
    
	$this->conditions = $conditions;
    $this->status = $status;
    
  }
  
  function getSearchConditionsTitle()
  {
    return $this->createCondition($this->parameters['search_query'], 'f.title', 'OR');
  }
  
  function getSearchConditionsDescription()
  {
    return $this->createCondition($this->parameters['search_query'], 'f.feedback_content', 'OR');
  }

  function getSearchConditionsCategory()
  {
    return $this->createCondition($this->parameters['search_query'], 'c.title', 'OR');
  }

  
  function createCondition($search_query, $field_name, $operand)
  {
    $database = JFactory::getDbo();

    $queries = explode(',', $search_query);
    $condition = '(';
    
    $first = true;
    foreach ($queries as $query)
    {
      if (!$first)
      {
        $condition .= ' ' . $operand . ' ';
      }

      $query = $database->escape(trim($query));
      $condition .= $field_name . ' LIKE "%' . $query . '%"';
      $first = false;
    }
    $condition .= ')';
    return $condition;
  }
 
  function getFeedbacks()
  {
    switch ($this->parameters['search_type'] ) {
    	case 0:
    		$feedbacks['feedbacks_pending'] = $this->getFeedbacksPending();
    		$feedbacks['feedbacks_planned'] = $this->getFeedbacksPlanned();
    		$feedbacks['feedbacks_started'] = $this->getFeedbacksStarted();
    		break;
    	case 4:
    		$feedbacks['feedbacks_pending'] = $this->getFeedbacksPending();
    		break;
    	case 5:
    		$feedbacks['feedbacks_started'] = $this->getFeedbacksStarted();
    		break;
    	case 6:
    		$feedbacks['feedbacks_planned'] = $this->getFeedbacksPlanned();
    		break;		
    	default:
    		$feedbacks['feedbacks_pending'] = $this->getFeedbacksPending();
    		$feedbacks['feedbacks_planned'] = $this->getFeedbacksPlanned();
    		$feedbacks['feedbacks_started'] = $this->getFeedbacksStarted();
    		
    		break;
    }

    return $feedbacks;
  }

  function getFeedbacksRaw()
  {
      $type = JFactory::getApplication()->input->getCmd('type', 'pending');

    switch ($type) {
    	case 'pending':
    		$feedbacks = $this->getFeedbacksPending();
    		break;
    	case 'started':
    		$feedbacks = $this->getFeedbacksStarted();
    		break;
    	case 'planned':
    		$feedbacks = $this->getFeedbacksPlanned();
    		break;		
    	default:
    		$feedbacks = $this->getFeedbacksPending();
    		break;
    }
    
    return $feedbacks;
  }
  

  function getFeedbacksPending()
  {
    $query = $this->_buildQuery('pending');
    $feedbacks_pending = $this->_getList($query, $this->limitstart, $this->feedbacks_per_page);

    return $feedbacks_pending;
  }

  function getFeedbacksPlanned()
  {
    $query = $this->_buildQuery('planned');
    $feedbacks_planned = $this->_getList($query, $this->limitstart, $this->feedbacks_per_page);
    
    return $feedbacks_planned;
  }

  function getFeedbacksStarted()
  {
    $query = $this->_buildQuery('started');
    $feedbacks_started = $this->_getList($query, $this->limitstart, $this->feedbacks_per_page);

    return $feedbacks_started;
  }
    
  function getTotalPending()
  {
    if (empty($this->_total_pending))
    {
  		$query = $this->_buildQuery('pending');
    	$this->_total_pending = $this->_getListCount($query);
    }
    return $this->_total_pending;
  }

  function getTotalPlanned()
  {
    if (empty($this->_total_planned))
    {
  		$query = $this->_buildQuery('planned');
    	$this->_total_planned = $this->_getListCount($query);
    }
    return $this->_total_planned;
  }


  function getTotalStarted()
  {
    if (empty($this->_total_started))
    {
  		$query = $this->_buildQuery('started');
    	$this->_total_started = $this->_getListCount($query);
    }
    return $this->_total_started;
  }
  
  /*
  function getTotalPagination()
  {
    switch ($this->parameters['search_type'] ) {
    	case 0:
    		$pagination['pagination_pending'] = $this->getPaginationPending();
    		$pagination['pagination_planned'] = $this->getPaginationPlanned();
    		$pagination['pagination_started'] = $this->getPaginationStarted();
    		break;
    	case 4:
    		$pagination['pagination_pending'] = $this->getPaginationPending();
    		break;
    	case 5:
    		$pagination['pagination_started'] = $this->getPaginationStarted();
    		break;
    	case 6:
    		$pagination['pagination_planned'] = $this->getPaginationPlanned();
    		break;		
    	default:
    		$pagination['pagination_pending'] = $this->getPaginationPending();
    		$pagination['pagination_planned'] = $this->getPaginationPlanned();
    		$pagination['pagination_started'] = $this->getPaginationStarted();
    		
    		break;
    }
    return $pagination;
  }*/
  
  function getPaginationRaw()
  {
    $type = JFactory::getApplication()->input->getCmd('type', 'pending');
  	
    switch ($type) {
    	case 'pending':
    		$pagination['pagination_pending'] = $this->getPaginationPending();
    		break;
    	case 'started':
    		$pagination['pagination_started'] = $this->getPaginationStarted();
    		break;
    	case 'planned':
    		$pagination['pagination_planned'] = $this->getPaginationPlanned();
    		break;		
    	default:
    		$pagination['pagination_pending'] = $this->getPaginationPending();
    		break;
    }
   
    return $pagination;
  	
  }
  
  function getPaginationPending()
  {
    if (empty($this->_pagination_pending))
    {
  		jimport('joomla.html.pagination');

    	$this->_pagination_pending = new JPagination($this->getTotalPending(), $this->limitstart, $this->feedbacks_per_page);
    }

    return $this->_pagination_pending;
  }

  function getPaginationPlanned()
  {
    if (empty($this->_pagination_planned))
    {
  		jimport('joomla.html.pagination');

    	$this->_pagination_planned = new JPagination($this->getTotalPlanned(), $this->limitstart, $this->feedbacks_per_page);
    }
    return $this->_pagination_planned;
  }

  function getPaginationStarted()
  {
    if (empty($this->_pagination_started))
    {
  		jimport('joomla.html.pagination');

    	$this->_pagination_started = new JPagination($this->getTotalStarted(), $this->limitstart, $this->feedbacks_per_page);
    }
    return $this->_pagination_started;
  }
  
}
