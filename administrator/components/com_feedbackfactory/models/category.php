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

class BackendModelCategory extends JModelLegacy
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
      $query = ' SELECT * FROM #__feedback_categories'
             . ' WHERE id = '.$this->_id;
      $this->_db->setQuery($query);

      $this->_data = $this->_db->loadObject();
    }

    if (!$this->_data)
    {
      $this->_data = $this->getTable();
      $this->_data->published = 1;
    }

    return $this->_data;
  }
  
  function change()
  {
      $app = JFactory::getApplication();

      $field = $app->input->getString('field', '');
      $value = $app->input->getInt('value',  0);
      $id    = $app->input->getInt('id',     0);

    if (!in_array($field, array('published')))
    {
      return false;
    }

    $query = ' UPDATE #__feedback_categories'
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
    $category =& $this->getTable();
    $data =  JFactory::getApplication()->input->getArray($_POST);

    if (!$category->bind($data))
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (!$category->check())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (!$category->store())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    return true;
  }

  function delete()
  {
    $cids    = JFactory::getApplication()->input->get('cid', array(0), 'array');
    $category =& $this->getTable();

    foreach($cids as $cid)
    {
      if (!$category->delete($cid))
      {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }
    return true;
  }

}
