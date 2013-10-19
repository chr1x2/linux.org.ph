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

class FrontendViewFeedback extends JViewLegacy
{
  function __construct()
  {
    parent::__construct();

    $this->feedbackHelper   = feedbackHelper::getInstance();
    $this->feedbackSettings = new feedbackSettings();
  }

  function display($tpl = null)
  {
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'recaptcha'.DS.'recaptchalib.php');
    $app = JFactory::getApplication();
    $Itemid   = $app->input->getInt('Itemid',0);

    feedbackHelper::checkGuestView();
    //$model   =& JModelLegacy::getInstance('feedback', 'FrontendModel');
    $feedback = $this->getModel()->getData();

    if (!is_null($feedback))
    {
        $app->input->set('id', $feedback->id, 'GET');
    }

    $user   = JFactory::getUser();

    $isCBIntegration = FeedbackHelper::getCBIntegration();
    if ($isCBIntegration) {
        $avatar_image = FeedbackHelper::getAvatar($user->id, 'cb');
    }

    $this->assignRef('feedback',                 $feedback);
    $this->assignRef('user',                 	$user);
    $this->assignRef('Itemid',               	$Itemid);
    $this->assignRef('allow_guest_comments', 	$this->feedbackSettings->allow_guest_comments);
    $this->assignRef('captcha_comment',      	$this->feedbackSettings->captcha_comment);
    $this->assignRef('guest_captcha_comment',   $this->feedbackSettings->guest_captcha_comment);
    $this->assignRef('isCBIntegration',         $isCBIntegration);
    $this->assignRef('avatar_image',            $avatar_image);

   if ($this->feedbackSettings->captcha_comment || $this->feedbackSettings->guest_captcha_comment)
    {
      $this->assignRef('captcha_html', recaptcha_get_html(base64_decode($this->feedbackSettings->recaptcha_public_key)));
    }

    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/main.css');
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/jquery-ui-1.7.2.custom.css');

    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/views/feedback/default.js');

    if ($feedback)
    {
      $declarations = array(
        'txt_loading_comments'  	=> JText::_('FEEDBACK_LOADING_COMMENTS'),
        'root'                  	=> JURI::base(),
        'feedback_id'               => !is_null($feedback) ? $feedback->id : 0,
        'captcha_comment'       	=> $this->feedbackSettings->captcha_comment,
        'guest_captcha_comment'     => $this->feedbackSettings->guest_captcha_comment,
        'txt_field_required'    	=> JText::_('FEEDBACK_FIELD_REQUIRED'),
        'txt_comment_added'     	=> JText::_('FEEDBACK_COMMENT_ADDED'),
        'route_feedback_comment'	=> JRoute::_('index.php?option=com_feedbackfactory&controller=comment&task=addComment', false),
        'route_load_comments'   	=> JRoute::_('index.php?option=com_feedbackfactory&view=comments&feedback_id=' . $feedback->id, false),
      );
//&layout=_list
      feedbackHelper::addScriptDeclarations($declarations);

      $document = JFactory::getDocument();
      $document->setTitle($feedback->title);
    }

    parent::display($tpl);
  }

}
