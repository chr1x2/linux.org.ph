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

class BackendModelDashboard extends JModelLegacy
{
  function __construct()
  {
    parent::__construct();
  }

  function getLatestFeedbacks()
  {
    $query = ' SELECT f.id, f.title, f.user_id, f.date_created, IF (f.user_id != 0, u.username, "Guest") AS username'
           . ' FROM #__feedback_feedbacks f'
           . ' LEFT JOIN #__users u ON u.id = f.user_id'
           . ' ORDER BY f.date_created DESC'
           . ' LIMIT 0,10';
    $this->_db->setQuery($query);
    return $this->_db->loadObjectList();
  }

  function getTotalFeedbacks()
  {
    $query = ' SELECT COUNT(f.id)'
           . ' FROM #__feedback_feedbacks f';
    $this->_db->setQuery($query);
    return $this->_db->loadResult();
  }
  
  function getLatestComments()
  {
    $query = ' SELECT c.*'
           . ' FROM #__feedback_comments c'
           . ' ORDER BY c.date_added DESC'
           . ' LIMIT 0, 5';

    $this->_db->setQuery($query);
    return $this->_db->loadObjectList();
  }
  
  function getTotalComments()
  {
    $query = ' SELECT COUNT(c.id)'
           . ' FROM #__feedback_comments c';
    $this->_db->setQuery($query);
    return $this->_db->loadResult();
  }
  
  function getMostVotedFeedbacks()
  {
    $query = ' SELECT f.id, f.title, f.user_id, v.voted_at, f.hits, IF (v.user_id != 0, u.username, "Guest") AS username'
           . ' FROM #__feedback_votes v'
           . ' LEFT JOIN #__feedback_feedbacks f ON f.id = v.feedback_id'
           . ' LEFT JOIN #__users u ON u.id = f.user_id'
           . ' ORDER BY f.hits DESC'
           . ' LIMIT 0,5';
    $this->_db->setQuery($query);
    return $this->_db->loadObjectList();
  }

  function getNewFeedbacks()
  {
    $timestamp = mktime(0, 0, 0, date('m'), date('d') - date('w'), date('Y'));

    $query = ' SELECT COUNT(f.id)'
           . ' FROM #__feedback_feedbacks f'
           . ' WHERE UNIX_TIMESTAMP(f.date_created) >= ' . $timestamp;

    $this->_db->setQuery($query);
    return $this->_db->loadResult();
  }
  
  function getNewComments()
  {
    $timestamp = mktime(0, 0, 0, date('m'), date('d') - date('w'), date('Y'));

    $query = ' SELECT COUNT(c.id)'
           . ' FROM #__feedback_comments c'
           . ' WHERE UNIX_TIMESTAMP(c.date_added) >= ' . $timestamp;

    $this->_db->setQuery($query);
    return $this->_db->loadResult();
  }
 
  
}
