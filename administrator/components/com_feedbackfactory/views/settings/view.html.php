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

class BackendViewSettings extends JViewLegacy
{
  function display($tpl = null)
  {
    JToolBarHelper::title(JText::_('Settings'), 'cpanel.png');
    JToolBarHelper::apply('save');

    $acl    =& JFactory::getACL();
    //$pane   =& JPane::getInstance('tabs', array('startOffset' => 0));
    $groups = $this->get('Groups');

    $settings =  new feedbackSettings();
    $detectedCBPlugin = feedbackHelper::detectCBPlugin('feedback_factory');

    $admins   =& $this->get('Admins');

    $this->assignRef('pane',         	$pane);
    $this->assignRef('groups',       	$groups);
    $this->assignRef('users',        	$users);
    $this->assignRef('admins',       	$admins);
    $this->assignRef('feedbackSettings', $settings);
    $this->assignRef('detectedCBPlugin', $detectedCBPlugin);
    $this->assignRef('router',       	$router);

    JHTML::_('behavior.tooltip');
          // Javascripts
      $document = JFactory::getDocument();
      $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/jquery.js');
      //JHTML::script('components/com_feedbackfactory/assets/js/jquery.js');

    parent::display($tpl);
  }
}
