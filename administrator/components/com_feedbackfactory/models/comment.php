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

class BackendModelComment extends JModelLegacy
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
      $query = ' SELECT * FROM #__feedback_comments'
             . ' WHERE id = '.$this->_id;
      $this->_db->setQuery($query);

      $this->_data = $this->_db->loadObject();
    }

    if (!$this->_data)
    {
      $this->_data = $this->getTable();
    }

    return $this->_data;
  }

  function store()
  {
    $comment =& $this->getTable();
    $data =  JFactory::getApplication()->input->getArray($_POST);
    $data['comment'] = JFactory::getApplication()->input->getString('content', '');
    
    if (!$comment->bind($data))
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (!$comment->check())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }
    
    if (!$comment->store())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    return true;
  }
  
  function delete()
  {
    $cids    = JFactory::getApplication()->input->get('cid', array(0), 'array');
    $comment =& $this->getTable();

    foreach ($cids as $cid)
    {
      if (!$comment->delete($cid))
      {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }
    return true;
  }
  
}
