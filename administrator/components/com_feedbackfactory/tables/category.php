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

class TableCategory extends JTable
{
  var $id        = null;
  var $title     = null;
  var $published = null;
  var $ordering  = null;

  function TableCategory(&$db)
  {
    parent::__construct('#__feedback_categories', 'id', $db);
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
    $this->deleteFeedbacks();

    return parent::delete($oid);
  }
  
  function getComments()
  {
    $query = ' SELECT c.id'
           . ' FROM #__feedback_comments c'
           . ' LEFT JOIN #__feedback_feedbacks f'
           . ' ON c.feedback_id = f.id'
           . ' WHERE f.category_id = ' . $this->id;
    $this->_db->setQuery($query);

    return $this->_db->loadObjectList();
  }

  function getVotes()
  {
    $query = ' SELECT v.id'
           . ' FROM #__feedback_votes v'
           . ' LEFT JOIN #__feedback_feedbacks f'
           . ' ON v.feedback_id = f.id'
           . ' WHERE f.category_id = ' . $this->id;
    $this->_db->setQuery($query);

    return $this->_db->loadObjectList();
  }
  
  
  function getFeedbacks()
  {
    $query = ' SELECT f.id'
           . ' FROM #__feedback_feedbacks f'
           . ' WHERE f.category_id = ' . $this->id;
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

  function deleteFeedbacks()
  {
    $feedbacks      =  $this->getFeedbacks();
    $feedbacks_table =& JTable::getInstance('feedback', 'Table');

    foreach ($feedbacks as $feedback)
    {
      $feedbacks_table->delete($feedback->id);
    }
  }
  
  
}
