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

class FrontendViewFeedbacks extends JViewLegacy
{
  function display($tpl = null)
  {
    $app = JFactory::getApplication();
    $Itemid   = $app->input->getInt('Itemid',0);

    $this->feedbackSettings = new feedbackSettings();
    $this->feedbackHelper   = feedbackHelper::getInstance();

    feedbackHelper::checkGuestView();  

    $model   = $this->getModel();
    $feedbacks = $model->getFeedbacks();

    $this->assignRef('Itemid', $Itemid);

    if (empty($feedbacks))
    {
      $tpl = 'no_feedback';
    }
    else
    {
      $pagination = $model->getPagination();

      $completed_status_id = feedbackHelper::getStatusId('completed');
      $completed_id_status = (int)$completed_status_id;

      $this->assignRef('feedbacks',     $feedbacks);
      $this->assignRef('pagination', 	$pagination);
      $this->assignRef('completed_id_status',   $completed_id_status);
  	  $this->assignRef('feedbackSettings',   	$this->feedbackSettings);
    }

    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/main.css');

    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/jquery-ui-1.8.9.custom.min.js');
    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/jquery.watermark.js');
    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/search.js');
    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/vote.js');

    if (!empty($feedbacks))
    {
      $declarations = array(
        'txt_loading_comments'  => JText::_('FEEDBACK_LOADING_COMMENTS'),
        'root'                  => JURI::base(),
        'route_vote'            => JRoute::_('index.php?option=com_feedbackfactory&controller=feedback&task=vote', false),
        'route_search'			=> JRoute::_('index.php?option=com_feedbackfactory&format=raw&task=search', false)
      );
      feedbackHelper::addScriptDeclarations($declarations);

    }

    parent::display($tpl);
  }

}
?>
