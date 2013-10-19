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

jimport('joomla.application.component.view');

class FrontendViewComments extends JViewLegacy
{
  function __construct()
  {
    parent::__construct();

    $this->feedbackHelper   = feedbackHelper::getInstance();
    $this->feedbackSettings = new feedbackSettings();
  }

  function display($tpl = null)
  {
    $user       = JFactory::getUser();
    $model   =& JModelLegacy::getInstance('Comments', 'FrontendModel');

    $comments   = $model->getData();
    $pagination = $model->getPagination();
    $feedback  	= $model->getFeedback();

    $isCBIntegration = FeedbackHelper::getCBIntegration();
    if ($isCBIntegration) {
        $avatar_image = FeedbackHelper::getAvatar($user->id, 'cb');
    }

    $this->assignRef('comments',   			$comments);
    $this->assignRef('pagination', 			$pagination);
    $this->assignRef('feedback',       		$feedback);
    $this->assignRef('user',       			$user);
    $this->assignRef('feedbackSettings',	$this->feedbackSettings);
    $this->assignRef('isCBIntegration',         $isCBIntegration);
    $this->assignRef('avatar_image',        $avatar_image);

    parent::display($tpl);
  }
}
