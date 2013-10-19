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

class BackendModelFeedback extends JModelLegacy
{
  function __construct()
  {
	parent::__construct();
		
    $cids    = JFactory::getApplication()->input->get('cid', array(0), 'array');
    $this->setId((int)$cids[0]);
  }

  function setId($id)
  {
    $this->_id   = $id;
    $this->_data = null;
  }

  function &getData()
  {
    if (empty($this->_data))
    {
      $query = ' SELECT f.*, IF (f.user_id != 0, u.username, "Guest") AS username'
      . ' FROM #__feedback_feedbacks f'
      . ' LEFT JOIN #__users u ON u.id = f.user_id'
      . ' WHERE f.id = ' . $this->_id;
      $this->_db->setQuery($query);

      $this->_data = $this->_db->loadObject();
    }

    if (!$this->_data)
    {
      $this->_data = $this->getTable();
    }

    return $this->_data;
  }

  function getCategories()
  {
    $feedbackSettings = new feedbackSettings();
    // Custom categories

    $query = ' SELECT *'
        . ' FROM #__feedback_categories'
        . ' WHERE published = 1'
        . ' ORDER BY title ASC';
        
    $this->_db->setQuery($query);
    $result = $this->_db->loadObjectList();
    
    $categories = array();

    foreach ($result as $category)
    {
       $categories[$category->id] = array('title' => $category->title);
    }

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


  function change()
  {
      $app = JFactory::getApplication();

      $field = $app->input->getString('field', '');
      $value = $app->input->getInt('value',  0);
      $id    = $app->input->getInt('id',     0);
    
    if (!in_array($field, array('published', 'category_id')))
    {
      return false;
    }

    $query = ' UPDATE #__feedback_feedbacks'
    . ' SET ' . $field . ' = ' . $value
    . ' WHERE id = ' . $id;
    $this->_db->setQuery($query);

    return $this->_db->query();
  }

  function publish()
  {
      $app = JFactory::getApplication();
      $cids    = $app->input->get('cid', array(0), 'array');

      $app->input->set('field', 'published', 'GET');
      $app->input->set('value', 1, 'GET');

    foreach ($cids as $cid)
    {
        $app->input->set('id', $cid, 'GET');

      if (!$this->change())
      {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

  function unpublish()
  {
      $app = JFactory::getApplication();
      $cids    = $app->input->get('cid', array(0), 'array');

      $app->input->set('field', 'published', 'GET');
      $app->input->set('value', 0, 'GET');

    foreach ($cids as $cid)
    {
        $app->input->set('id', $cid, 'GET');

      if (!$this->change())
      {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

  function store()
  {
    $feedback =& $this->getTable();
    $data =  JFactory::getApplication()->input->getArray($_POST);
      $f=new JFilterInput(array(),array(),1,1);
      $data['feedback_content'] = $f->clean($_REQUEST['feedback_content'],'html');

    if (!$feedback->bind($data))
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (!$feedback->check())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (empty($feedback->id))
    {
      $feedback->date_created = date('Y-m-d H:i:s');
      $user = JFactory::getUser();
      $feedback->user_id = $user->id;
    }

    $feedback->date_updated = date('Y-m-d H:i:s');

    if (!$feedback->store())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    return true;
  }

  function delete()
  {
    $cids    = JFactory::getApplication()->input->get('cid', array(0), 'array');
    $feedback =& $this->getTable();

    foreach($cids as $cid)
    {
      if (!$feedback->delete($cid))
      {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }
    return true;
  }
  
  
}
