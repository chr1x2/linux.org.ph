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

class FrontendModelFeedback extends JModelLegacy
{
  var $_feedback;
  var $_tags;

  function __construct()
  {
    parent::__construct();

    $this->feedbackSettings = new feedbackSettings();
  }

  function getData()
  {
      $app = JFactory::getApplication();
      $feedback_id = $app->input->getInt('id', 0);

      $query = ' SELECT DISTINCT f.*, IF (f.user_id != 0, u.username, "Guest") AS username, IF(f.hits != 0, f.hits, 0) as hits, c.title as category_title, s.status '
    	   . ' ,(SELECT COUNT(m.id) from #__feedback_comments m WHERE m.feedback_id = f.id ) AS no_comments '
           . ' FROM #__feedback_feedbacks f'
           . ' LEFT JOIN #__users u ON f.user_id = u.id'
           . ' LEFT JOIN #__feedback_votes v ON v.feedback_id = f.id '
           . ' LEFT JOIN #__feedback_categories c ON c.id = f.category_id '
           . ' LEFT JOIN #__feedback_statuses s ON s.id = f.status_id '
           . ' LEFT JOIN #__feedback_comments m ON m.feedback_id = f.id '
           . ' WHERE f.id = '.$feedback_id;
    
    $this->_db->setQuery($query);
    $feedback = $this->_db->loadObject();

    $this->_feedback = $feedback;

 
    return $this->_feedback;
  }

  function updateViews($id, $views)
  {
    $query = ' UPDATE #__feedback_feedbacks'
           . ' SET views = ' . ($views + 1)
           . ' WHERE id = ' . $id;
    $this->_db->setQuery($query);
    $this->_db->query();
  }

}
