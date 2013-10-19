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

class BackendModelChangex extends JModelLegacy
{
  function __construct()
  {
    parent::__construct();
  }

  function getFeedbacks()
  {
      $cid    = JFactory::getApplication()->input->get('cid', array(), 'array');
    JArrayHelper::toInteger($cid);

    return $cid;
  }

  function getCategories()
  {
    $query = ' SELECT c.id, c.title'
           . ' FROM #__feedback_categories c'
           . ' WHERE c.published = 1'
           . ' ORDER BY c.title ASC';
    $this->_db->setQuery($query);

    return JHTML::_('select.genericlist', $this->_db->loadObjectList(), 'category_id', 'class="inputbox" size="1"', 'id', 'title');
  }

  function changeCategories()
  {
    $cid    = JFactory::getApplication()->input->get('cid', array(), 'array');
    JArrayHelper::toInteger($cid);

    if (!count($cid))
    {
      JError::raiseWarning(0, JText::_('FEEDBACK_NO_FEEDBACKS_SELECTED'));
      return false;
    }

    $category_id =  JFactory::getApplication()->input->getInt('category_id', 0);
    $category    =& $this->getTable('category', 'Table');
    
    $category->load($category_id);
    if (count($category->_errors))
    {
      JError::raiseWarning(0, JText::_('FEEDBACK_CATEGORY_NOT_FOUND'));
      return false;
    }

    $query = ' UPDATE #__feedback_feedbacks'
           . ' SET category_id = ' . $category_id
           . ' WHERE id IN (' . implode(',', $cid) . ')';
    $this->_db->setQuery($query);
    if (!$this->_db->query())
    {
      JError::raiseWarning(0, $this->_db->getErrorMsg());
      return false;
    }

    return true;
  }
  
  function getStatuses()
  {
  	$query = ' SELECT s.* '
           . ' FROM #__feedback_statuses s'
           . ' WHERE s.published = 1'
           . ' ORDER BY s.status ASC';
    
    $this->_db->setQuery($query);
	$statuses= $this->_db->loadAssocList();
	return JHTML::_('select.genericlist', $this->_db->loadObjectList(), 'status_id', 'class="inputbox" size="1"', 'id', 'status');
	
  }
  
  function changeStatuses()
  {
    $cid    = JFactory::getApplication()->input->get('cid', array(), 'array');
    JArrayHelper::toInteger($cid);
        
    if (!count($cid))
    {
      JError::raiseWarning(0, JText::_('FEEDBACK_NO_FEEDBACKS_SELECTED'));
      return false;
    }
   
    $completed_status_id = feedbackHelper::getStatusId('completed');
    $completed_id = (int)$completed_status_id;
    
   	$status_id = JFactory::getApplication()->input->getInt('status_id', 0);
    $status    =& $this->getTable('status', 'Table');
    
	$status->load($status_id);
	if (count($status->_errors))
	{
	    JError::raiseWarning(0, JText::_('FEEDBACK_STATUS_NOT_FOUND'));
	    return false;
	}
	
	$query = ' UPDATE #__feedback_feedbacks'
	       . ' SET status_id = ' . $status_id
	       . ' WHERE id IN (' . implode(',', $cid) . ')';
	           
	$this->_db->setQuery($query);
	   
	if (!$this->_db->query())
	{
	  JError::raiseWarning(0, $this->_db->getErrorMsg());
	  return false;
	}
	
	return true;
  } 
  	     
  
  
  
}
