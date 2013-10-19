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

class BackendControllerFeedback extends BackendController
{
	function __construct()
	{
		parent::__construct();

		$this->registerTask('add', 'edit');
	}

	function edit()
   {
       $app = JFactory::getApplication();

       $app->input->set('view', 'feedback', 'POST');
       $app->input->set('layout', 'form', 'POST');
       $app->input->set('hidemainmenu', 1, 'POST');

        parent::display();
   }

   function change()
   {
    $model = $this->getModel('feedback');

    if ($model->change())
    {
      $msg = JText::_('FEEDBACK_STATE_CHANGED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_ERROR_CHANGING_STATE');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
   }

  function publish()
  {
    $model = $this->getModel('feedback');

    if ($model->publish())
    {
      $msg = JText::_('FEEDBACK_FEEDBACKS_PUBLISHED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_FEEDBACKS_ERROR_PUBLISH');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
  }

  function unpublish()
  {
    $model = $this->getModel('feedback');

    if ($model->unpublish())
    {
      $msg = JText::_('FEEDBACK_FEEDBACKS_UNPUBLISHED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_FEEDBACKS_ERROR_UNPUBLISH');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
  }

  function remove()
  {
    $model = $this->getModel('feedback');

    if (!$model->delete())
    {
      $msg = JText::_('Error: One or More Feedbacks Could not be Deleted');
    }
    else
    {
      $msg = JText::_('FEEDBACK_FEEDBACKS_DELETED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
  }

  function save()
  {
    $model = $this->getModel('feedback');

    if ($model->store())
    {
      $msg = JText::_('FEEDBACK_SAVED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_ERROR_SAVED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
  }

  function cancel()
  {
    $msg = JText::_('FEEDBACK_OPERATION_CANCELLED');
    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
  }

  function changeCategories()
  {
    $model =& $this->getModel('changex', 'BackendModel');

    if ($model->changeCategories())
    {
      $msg = JText::_('FEEDBACK_CATEGORY_CHANGED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_CATEGORY_ERROR_CHANGED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
  }
  
  function changeStatuses()
  {
    $model =& $this->getModel('changex', 'BackendModel');

    if ($model->changeStatuses())
    {
      $msg = JText::_('FEEDBACK_STATUS_CHANGED');
    }
    else
    {
      $msg = JText::_('FEEDBACK_STATUS_ERROR_CHANGED');
    }

    $this->setRedirect('index.php?option=com_feedbackfactory&task=feedbacks', $msg);
  }
    
}
