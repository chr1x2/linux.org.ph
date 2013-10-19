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

    feedbackHelper::checkGuestView();
    $user   = JFactory::getUser();

    $feedbacks   =& $this->get('Feedbacks');

	$pagination_pending =& $this->get('PaginationPending');
	$pagination_started =& $this->get('PaginationStarted');
	$pagination_planned =& $this->get('PaginationPlanned');
    
    $this->assignRef('user',                	$user);
    $this->assignRef('Itemid',               	$Itemid);
    
    $this->assignRef('feedbacks_pending',		$feedbacks['feedbacks_pending']);
    $this->assignRef('feedbacks_started',    	$feedbacks['feedbacks_started']);
    $this->assignRef('feedbacks_planned',    	$feedbacks['feedbacks_planned']);
    
    $this->assignRef('pagination_pending', 		$pagination_pending);
    $this->assignRef('pagination_started', 		$pagination_started);
    $this->assignRef('pagination_planned', 		$pagination_planned);

    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/main.css');
    $document->addStyleSheet(JUri::root().'components/com_feedbackfactory/assets/css/jquery-ui-1.7.2.custom.css');

    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/jquery-ui-1.8.9.custom.min.js');
    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/jquery.watermark.js');
    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/search.js');
    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/vote.js');

    if (!empty($feedbacks['feedbacks_pending']) || !empty($feedbacks['feedbacks_started']) || !empty($feedbacks['feedbacks_planned']))
    {
      $declarations = array(
        'root'                  => JURI::base(),
        'route_vote'            => JRoute::_('index.php?option=com_feedbackfactory&controller=feedback&task=vote', false),
        'route_search'			=> JRoute::_('index.php?option=com_feedbackfactory&format=raw&task=search_accepted', false)
      );
      feedbackHelper::addScriptDeclarations($declarations);
    }

    parent::display($tpl);
  }

}
