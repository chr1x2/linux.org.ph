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

class FrontendViewBrowse extends JViewLegacy
{
  function display($tpl = null)
  {
    $app = JFactory::getApplication();
    $Itemid   = $app->input->getInt('Itemid',0);
    
    $this->feedbackSettings = new feedbackSettings();
    $this->feedbackHelper   = feedbackHelper::getInstance();
    feedbackHelper::checkGuestView();  

    $feedbacks = $this->getModel()->getFeedbacks();
    
    $this->assignRef('Itemid', $Itemid);

      $completed_status_id = feedbackHelper::getStatusId('completed');
      $completed_id_status = (int)$completed_status_id;
      $pagination = $this->getModel()->getPagination();

      $this->assignRef('feedbacks',     		$feedbacks);
      $this->assignRef('completed_id_status',   $completed_id_status);
      $this->assignRef('pagination', 			$pagination);
      $this->assignRef('feedbackSettings',   	$this->feedbackSettings);

    parent::display('list');
  }
}
