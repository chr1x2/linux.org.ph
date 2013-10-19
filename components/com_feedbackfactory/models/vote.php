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

class FrontendModelVote extends JModelLegacy
{
  var $feedback_id;

  function __construct()
  {
	$this->feedback_id  	= JFactory::getApplication()->input->getInt('feedback_id',   0);
    $settings = new feedbackSettings();
  
    parent::__construct();
  }

  function registerVoter()
  {
    $settings =  new feedbackSettings();
    $database = JFactory::getDbo();
    $user     = JFactory::getUser();
    $date     =  date('Y-m-d H:i:s', time());
    $feedback_id  	= JFactory::getApplication()->input->getInt('feedback_id',   0);
    
    // Check if the user has already voted
	 $query = ' SELECT v.id, v.voted_at'
	         . ' FROM #__feedback_votes v'
	         . ' WHERE v.user_id = ' . $user->id
	         . ' AND v.feedback_id = ' . $feedback_id;
	
	$database->setQuery($query);
    $vote = $database->loadAssoc();

    // First vote from this voter
    if ($vote == null)
    {
      
		$vote	= JTable::getInstance('votes',    'Table');
		$vote->user_id      = $user->id;
		$vote->feedback_id  = $feedback_id;
		$vote->voted_at     = $date;
		  
		if (!$vote->store())
	  	{
	  		return false;
	  	}

      return true;
    }
    else 
    {
      if (!$settings->allow_multiple_votes) {
    		
    	die('{ "status": 0, "message": "' . JText::_('FEEDBACK_ALREADY_VOTED') . '" }');
      }
      else // multiple votes
      {
    	$query = 'SELECT id '
	    	 . ' FROM #__feedback_votes'
	     	 . ' WHERE (unix_timestamp(date_format("'.$vote['voted_at'].'","%Y-%m-%d 00:00:00"))) '
			 . ' BETWEEN (unix_timestamp(date_format(curdate()-interval 1 day,"%Y-%m-%d 00:00:00"))) '
			 . ' AND (unix_timestamp(date_format((curdate()),"%Y-%m-%d 00:00:00"))) '
	      		. ' AND user_id = ' . $user->id
		        . ' AND feedback_id = ' . $feedback_id
		        . ' LIMIT 0, 1';
	      
        $database->setQuery($query);
	    $voted = $database->loadResult();
        
	    if ($voted) // small interval between votes
	    {
	      return false;
	    } 
	    else 
	    {
 		  $query = ' UPDATE #__feedback_votes'
	             . ' SET voted_at = "' . $date . '"'
	             . ' WHERE user_id = ' . $user->id
	             . ' AND feedback_id = ' . $feedback_id;
	             
	      $database->setQuery($query);
	      $database->query();
	      return true;
	    }
      }
    	
    }

  }

  function registerVote()
  {
    $database = JFactory::getDbo();
    $user = JFactory::getUser();
    
    $feedback_id  	= JFactory::getApplication()->input->getInt('feedback_id',   0);

    // Check if the feedback exists
	$query = ' SELECT f.id'
	         . ' FROM #__feedback_feedbacks f'
	         . ' WHERE f.id = ' . $feedback_id;
	$database->setQuery($query);

	if (!$database->loadResult())
	{
	  die('{ "status": 0, "message": "' . JText::_('FEEDBACK_NOT_EXISTS') . '" }');
	}

	// register the vote
  	JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
	$feedback	= JTable::getInstance('feedback',    'Table');
	$feedback->load( $feedback_id, false );

	if ($feedback->hits > 0) {
	  	// Update the feedback vote
		$feedback->hit($feedback_id);
	}
	else 
	{
	    $feedback->hits = 1;
	}	
	  
	if (!$feedback->store())
  	{
	    return false;
  	}

  	return true;
	 
  }
}
