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
jimport('joomla.html.pane');

class FrontendViewAccepted extends JViewLegacy
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
  	
    $user   = JFactory::getUser();

 	$feedbacks   =& $this->get('FeedbacksRaw');
    $pagination =& $this->get('PaginationRaw');

    $pagination_type = array_keys($pagination);
    $pagination_type = $pagination_type[0];
    
    $this->assignRef('user',            	$user);
    $this->assignRef('feedbacks',			$feedbacks);
    $this->assignRef($pagination_type, 		$pagination[$pagination_type]);
    $this->assignRef('Itemid',          	$Itemid);
   
    parent::display('list');
  }

}
