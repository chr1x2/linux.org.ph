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

class BackendControllerSettings extends BackendController
{
	function __construct()
	{
		parent::__construct();
	}

  function save()
  {
    $model = $this->getModel('settings');

    if ($model->store())
    {
      $msg = JText::_('FEEDBACK_SETTINGS_SAVED');
      $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
    }
    else
    {
      $msg = JText::_('FEEDBACK_SETTINGS_ERROR_SAVE') . ' ' . $model->getError();
      $this->setRedirect('index.php?option=com_feedbackfactory&task=settings', $msg);
    }
    
  }
  
  function apply()
  {
    $model = $this->getModel('settings');

    if ($model->store())
    {
      $msg = JText::_('FEEDBACK_SETTINGS_SAVED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_SETTINGS_ERROR_SAVE') . ' ' . $model->getError();
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=settings', $msg);
  }

  function cancel()
  {
    $msg = JText::_('FEEDBACK_OPERATION_CANCELLED');
    $this->setRedirect('index.php?option=com_feedbackfactory&task=settings', $msg);
  }
}
