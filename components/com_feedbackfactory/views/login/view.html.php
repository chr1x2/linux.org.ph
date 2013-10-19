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

class FrontendViewLogin extends JViewLegacy
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

    $session = JFactory::getSession();

    $this->assignRef('Itemid',  $Itemid);
    $this->assignRef('referer', base64_encode($session->get('referer', JRoute::_('index.php'))));

    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/main.css');

    parent::display($tpl);
  }
  
}
