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

class BackendControllerComment extends BackendController
{
	function __construct()
	{
		parent::__construct();

		$this->registerTask('add', 'edit');
	}

	function edit()
    {
        $app = JFactory::getApplication();

        $app->input->set('view', 'comment', 'POST');
        $app->input->set('layout', 'form', 'POST');
        $app->input->set('hidemainmenu', 1, 'POST');

        parent::display();
    }


  function change()
  {
    $model = $this->getModel('comment');

    if ($model->change())
    {
      $msg = JText::_('FEEDBACK_STATE_CHANGED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_ERROR_CHANGING_STATE');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=comments', $msg);
  }
  
  function remove()
  {
    $model = $this->getModel('comment');

    if (!$model->delete())
    {
      $msg = JText::_('Error: One or More Comments Could not be Deleted');
    }
    else
    {
      $msg = JText::_('FEEDBACK_COMMENTS_DELETED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=comments', $msg);
  }

  function cancel()
  {
    $msg = JText::_('FEEDBACK_OPERATION_CANCELLED');

    $this->setRedirect('index.php?option=com_feedbackfactory&task=comments', $msg);
  }

  function save()
  {
    $model = $this->getModel('comment');

    if ($model->store())
    {
      $msg = JText::_('FEEDBACK_COMMENT_SAVED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_ERROR_SAVING_COMMENT');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=comments', $msg);
  }
}
