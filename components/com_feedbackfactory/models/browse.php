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

class FrontendModelBrowse extends JModelLegacy
{
  var $parameters;
  var $conditions = array();
  var $limitstart;
  var $limit;
  var $feedbacks_per_page;
  var $feedbackSettings;

  function __construct()
  {
    $app = JFactory::getApplication();
    $option = 'com_feedbackfactory';

    $this->feedbackSettings = new feedbackSettings();
	$this->feedbacks_per_page = $this->feedbackSettings->feedbacks_per_page;

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

  function _buildQuery()
  {
    $this->setConditions();
    $orderby = $this->_buildOrderByCondition();

    $query = $this->getQuery();
    #var_dump(str_replace('#__', 'jos_', $query));

    return $query;
  }
    
  function getQuery()
  {
    $orderby = $this->_buildOrderByCondition();
    $having = $this->_buildHavingCondition();
	$type = $this->parameters['type'];

    $query = ' SELECT DISTINCT f.*, IF (f.user_id != 0, u.username, "Guest") AS username, IF(f.hits != 0, f.hits, 0) as hits, c.title as category_title, s.status '
    	   . ' ,(SELECT COUNT(m.id) from #__feedback_comments m WHERE m.feedback_id = f.id ) AS no_comments '
    	   . ( ($this->parameters['type'] == '') ? ',"all" as type' : ', "'.$type.'" as type ')
    	   . ( ($this->parameters['type'] == 'search') ? ',"search" as type' : ', "'.$type.'" as type ')
           . ' FROM #__feedback_feedbacks f'
           . ' LEFT JOIN #__users u ON f.user_id = u.id'
           . ' LEFT JOIN #__feedback_votes v ON v.feedback_id = f.id '
           . ' LEFT JOIN #__feedback_categories c ON c.id = f.category_id '
           . ' LEFT JOIN #__feedback_statuses s ON s.id = f.status_id '
           . ' LEFT JOIN #__feedback_comments m ON m.feedback_id = f.id '
           . ' WHERE s.published = 1'
           . ' AND c.published = 1'
           . $this->conditions
           . $having
           . $orderby;

    return $query;
  }

  function _buildOrderByCondition()
  {
    switch ($this->parameters['type'])
    {
      case 'categoryfeedbacks':
        $orderby = ' ORDER BY date_updated DESC';
      break;

      case 'statusfeedbacks':
        $orderby = ' ORDER BY date_updated DESC';
      break;
      
      case 'mostcommented':
        $orderby = ' ORDER BY no_comments DESC';
      break;
      
      case 'top':
      	$orderby = ' ORDER BY f.hits DESC';
      	break;
      	
      default:
        $orderby = ' ORDER BY date_created DESC';
      break;
    }

    return $orderby;
  }
  
  function _buildHavingCondition()
  {
  	switch ($this->parameters['type'])
    {

      case 'mostcommented':
        $having = ' HAVING no_comments >= '.$this->feedbackSettings->min_most_commented;
      break;
      
      case 'top':
      	$having = ' HAVING hits >= '.$this->feedbackSettings->min_top_votes;
      	break;
      	
      default:
        $having = '';
      break;
    }

    return $having;
  	
  }

  function setConditions()
  {
  	$app = JFactory::getApplication();

    switch ($this->parameters['type'])
    {
      case 'mostcommented':
	    $conditions = '';
      break;

      case 'completed':
        $completed_id = feedbackHelper::getStatusId('completed');
        $conditions =  ' AND f.status_id = ' . $completed_id;
      break;

      case 'categoryfeedbacks':
        $id         = $app->input->getInt('category_id', 0);
        $conditions =  ' AND f.category_id = ' . $id;
      break;
      
      case 'statusfeedbacks':
      	$id         = $app->input->getInt('status_id', 0);
        $conditions =  ' AND f.status_id = ' . $id;
      break;	

      case 'top':
      	$conditions = '';
      	break;
      	      	
      case 'search':
      	$default_search = ' AND ( ' . $this->getSearchConditionsTitle()
                        . ' OR '    . $this->getSearchConditionsDescription()
                        . ' OR '    . $this->getSearchConditionsCategory()
                        . ' OR '    . $this->getSearchConditionsStatus() . ' )';
      	
        switch ($this->parameters['search_type'])
        {
          // Most commented
          case 1:
          	$conditions = $default_search . ' HAVING no_comments > '.$this->feedbackSettings->min_most_commented;
          	break;
          
          // Top
          case 2:
            $conditions = $default_search . '  HAVING hits > '.$this->feedbackSettings->min_top_votes;
          break;
          
           // Completed
          case 3:
          	$completed_id = feedbackHelper::getStatusId('completed');
          	
            $conditions = $default_search . ' AND f.status_id = ' . $completed_id;
          break;

          // all feedbacks case: 0
          default:
            $conditions = $default_search;
          break;
        }
        break;
      
      default:
      	$conditions = '';
      	break;
      
    }

    $this->conditions = $conditions;
    
  }
  
  function getFeedbacks()
  {
    $query = $this->_buildQuery();
    $data = $this->_getList($query, $this->limitstart, $this->feedbacks_per_page);

    return $data;
  }

  function getTotal()
  {
    $query = $this->_buildQuery();
    $total = $this->_getListCount($query);

    return $total;
  }

  function getPagination()
  {
    jimport('joomla.html.pagination');
    
    $pagination = new JPagination($this->getTotal(), $this->limitstart, $this->limit);
    return $pagination;
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
  
  function getSearchConditionsStatus()
  {
    return $this->createCondition($this->parameters['search_query'], 's.status', 'OR');
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
 
}
