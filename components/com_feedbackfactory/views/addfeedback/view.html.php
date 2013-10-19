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
jimport( 'joomla.access.access' );

class FrontendViewAddfeedback extends JViewLegacy
{
  function __construct()
  {
    parent::__construct();

    $this->feedbackHelper   = feedbackHelper::getInstance();
    $this->feedbackSettings = new feedbackSettings();
  }

  function display($tpl = null)
  {
      $app = JFactory::getApplication();
      $Itemid   = $app->input->getInt('Itemid',0);

      require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'recaptcha'.DS.'recaptchalib.php');

    feedbackHelper::checkGuestView(true);

    $model   = $this->getModel();
    $user    = JFactory::getUser();

    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/main.css');
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/jquery-ui-1.7.2.custom.css');

    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/tiny_mce/tiny_mce.js');

    $feedback       = $model->getData();
    $categories 	= $model->getCategories();
    $none_id 		= $this->feedbackHelper->getStatusId('none');

    $isCBIntegration = FeedbackHelper::getCBIntegration();

    $session = JFactory::getSession();
    $user    = JFactory::getUser();
 
    $this->assignRef('feedback', 			$feedback);
    $this->assignRef('categories', 			$categories);
    $this->assignRef('none_id', 			$none_id);
    $this->assignRef('feedbackSettings', 	$this->feedbackSettings);
    $this->assignRef('session',       		$session);
    $this->assignRef('root',          		JUri::root());
    $this->assignRef('Itemid',     			$Itemid);
	$this->assignRef('user',            	$user);
    $this->assignRef('isCBIntegration',     $isCBIntegration);

	// $this->assignRef('allow_guest_write',   	$this->feedbackSettings->allow_guest_write);
    // $this->assignRef('guest_captcha_write',   $this->feedbackSettings->guest_captcha_write);

   	if ($this->feedbackSettings->allow_guest_write && $this->feedbackSettings->guest_captcha_write)
    {
    	$this->assignRef('captcha_html', recaptcha_get_html(base64_decode($this->feedbackSettings->recaptcha_public_key)));
    }

    $document->addScriptDeclaration('var root = "' . JUri::root() . '";');

    parent::display($tpl);
  }

}
