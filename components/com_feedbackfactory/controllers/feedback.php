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

class FrontendControllerFeedback extends FrontendController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function vote()
	{
	  $user = JFactory::getUser();
	  $settings = new feedbackSettings();

	  // Check if the user is registered
	  if ($user->guest)
	  {
	    die('{ "status": 0, "message": "' . JText::_('FEEDBACK_VOTE_LOGIN') . '" }');
	  }
     
	 $feedback_id  	= JFactory::getApplication()->input->getInt('feedback_id',   0);
	 $model =& $this->getModel('vote');
	 // $voter = $model->registerVoter();
	 //$voted = $model->registerVote();

	 // Register voter
     if ($model->registerVoter())
     {
       // Register vote
       if ($model->registerVote() === false)
	   {
	     echo '{ "status": 0 }';
	   }
       else
       {
	   	$database 	= JFactory::getDbo();
	   	$query = ' SELECT f.hits'
	         . ' FROM #__feedback_feedbacks f'
	         . ' WHERE f.id = ' . $feedback_id;
	  	$database->setQuery($query);
	  	$vote_hits = $database->loadResult();
	 	
	 	echo('{ "status": 1, "hits": ' . $vote_hits . ', "message": "' . JText::_('FEEDBACK_VOTED_SUCCESFULLY') . '"}');
       }
     }
     else {
     	echo '{ "status": 2, "message": "' . JText::_('FEEDBACK_VOTE_INTERVAL') . '"  }';
     }
	}
	
	function save() 
	{
    	$model = $this->getModel('addfeedback');

    	$feedback = $model->store();

    	if ($feedback === false)
	    {
	      echo '{ "status": 0 }';
	    }
	    else
	    {
	      echo '{ "status": 1, "id": ' . $feedback->id . ', "last_saved": "' . $feedback->updated_at . '" }';
	    }
	
	}
}
