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

class TableFeedback extends JTable 
{
  var $id               = null;
  var $category_id      = null;
  var $status_id		= null;
  var $user_id			= null;
  var $title          	= null;
  var $feedback_content = null;
  var $date_created     = null;
  var $date_updated     = null;
  var $enable_comments  = null;
  var $enable_cb_avatar = null;
  var $hits     	= 0;
 
  function TableFeedback(&$db)
  {
    parent::__construct('#__feedback_feedbacks', 'id', $db);
  }
  
  function store()
  {
  	$this->feedback_content = feedbackHelper::stripJavascript($this->feedback_content);

    return parent::store();
  }
  
  // CRUD
  function delete($oid = null)
  {
    if ($oid)
    {
      $this->id = $oid;
    }

    $this->deleteComments();
    $this->deleteVotes();

    return parent::delete($oid);
  }
  
  function getComments()
  {
    $query = ' SELECT c.id'
           . ' FROM #__feedback_comments c'
           . ' WHERE c.feedback_id = ' . $this->id;
    $this->_db->setQuery($query);

    return $this->_db->loadObjectList();
  }

  function getVotes()
  {
    $query = ' SELECT v.id'
           . ' FROM #__feedback_votes v'
           . ' WHERE v.feedback_id = ' . $this->id;
    $this->_db->setQuery($query);

    return $this->_db->loadObjectList();
  }
  
  function deleteComments()
  {
    $comments      =  $this->getComments();
    $comment_table =& JTable::getInstance('comment', 'Table');

    foreach ($comments as $comment)
    {
      $comment_table->delete($comment->id);
    }
  }

  function deleteVotes()
  {
    $votes      =  $this->getVotes();
    $votes_table =& JTable::getInstance('votes', 'Table');

    foreach ($votes as $vote)
    {
      $votes_table->delete($vote->id);
    }
  }
  
}

?>
