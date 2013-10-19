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

class BackendControllerStatus extends BackendController
{
	function __construct()
	{
		parent::__construct();

		$this->registerTask('add', 'edit');
	}

	function edit()
    {
       $app = JFactory::getApplication();

       $app->input->set('view', 'status', 'POST');
       $app->input->set('layout', 'form', 'POST');
       $app->input->set('hidemainmenu', 1, 'POST');

       parent::display();
    }

	function change()
  {
    $model = $this->getModel('status');

    if ($model->change())
    {
      $msg = JText::_('FEEDBACK_STATE_CHANGED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_ERROR_CHANGING_STATE');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=statuses', $msg);
  }

  function publish()
  {
    $model = $this->getModel('status');

    if ($model->publish())
    {
      $msg = JText::_('FEEDBACK_STATUS_PUBLISHED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_STATUS_ERROR_PUBLISHED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=statuses', $msg);
  }

  function unpublish()
  {
    $model = $this->getModel('status');

    if ($model->unpublish())
    {
      $msg = JText::_('FEEDBACK_STATUS_UNPUBLISHED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_STATUS_ERROR_UNPUBLISHED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=statuses', $msg);
  }

  function remove()
  {
    $model = $this->getModel('status');

    if (!$model->delete())
    {
      $msg = JText::_('Error: One or More Statuses Could not be Deleted');
    }
    else
    {
      $msg = JText::_('FEEDBACK_STATUS_DELETED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=statuses', $msg);
  }

  function save()
  {
    $model = $this->getModel('status');

    if ($model->store())
    {
      $msg = JText::_('FEEDBACK_STATUS_SAVED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_STATUS_ERROR_SAVE');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=statuses', $msg);
  }

  function cancel()
  {
    $msg = JText::_('FEEDBACK_OPERATION_CANCELLED');
    $this->setRedirect('index.php?option=com_feedbackfactory&task=statuses', $msg);
  }

    
}
