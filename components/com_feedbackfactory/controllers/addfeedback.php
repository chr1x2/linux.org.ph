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

class FrontendControllerAddfeedback extends FrontendController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function save() 
	{
		$app = JFactory::getApplication();
        $Itemid   = $app->input->getInt('Itemid',0);
    	$model = $this->getModel('addfeedback');
		//$model   =& JModel::getInstance('addfeedback', 'FrontendModel');
    	
    	$feedback = $model->store();
    	
    	if ($feedback === false)
	    {
	      echo '{ "status_save": 0 }';
	    }
	    elseif ($feedback === 2) 
	    {
	    	echo '{ "status_save": 2 }'; //not unique
	    }
	    elseif ($feedback === 3) 
	    {
	    	echo '{ "status_save": 3 }';  //, "message": "' . JText::_('Invalid captcha! Try again!') . '"}
	    }
	    else
	    {
	      echo '{ "status_save": 1, "id": ' . $feedback->id . ', "last_saved": "' . $feedback->date_updated . '" }';
	    }
	
	}
}
