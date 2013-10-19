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
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define("COMPONENT_HOME_PAGE","http://www.thefactory.ro/");
define("COMPONENT_VERSION","2.0.0");
define("COMPONENT_NAME","com_feedbackfactory");
define("FF_COMPONENT_PATH",JPATH_ADMINISTRATOR.DS."components".DS."com_feedbackfactory".DS);

addSubmenu(JFactory::getApplication()->input->getCmd('task', 'settings'));
// import joomla controller library
jimport('joomla.application.component.controller');
JHtml::_('behavior.framework', true);

require_once (JPATH_COMPONENT.DS.'controller.php');

if ($controller = JFactory::getApplication()->input->getCmd('controller'))
{
	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

$classname = 'BackendController'.$controller;
$controller = new $classname();

$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();

function addSubmenu($vName)
{
	JSubMenuHelper::addEntry( JText::_('COM_FEEDBACK_SUBMENU_DASHBOARD'), 'index.php?option=com_feedbackfactory&task=dashboard', ($vName == 'dashboard') ? true : false);
	JSubMenuHelper::addEntry( JText::_('COM_FEEDBACK_SUBMENU_FEEDBACKS'), 'index.php?option=com_feedbackfactory&task=feedbacks', ($vName == 'feedbacks') ? true : false);
	JSubMenuHelper::addEntry( JText::_('COM_FEEDBACK_SUBMENU_CATEGORIES'),	'index.php?option=com_feedbackfactory&task=categories', ($vName == 'categories') ? true : false);
	JSubMenuHelper::addEntry( JText::_('COM_FEEDBACK_SUBMENU_STATUSES'),	'index.php?option=com_feedbackfactory&task=statuses', ($vName == 'statuses') ? true : false);
	JSubMenuHelper::addEntry( JText::_('COM_FEEDBACK_SUBMENU_COMMENTS'), 'index.php?option=com_feedbackfactory&task=comments', ($vName == 'comments') ? true : false);
	JSubMenuHelper::addEntry( JText::_('COM_FEEDBACK_SUBMENU_SETTINGS'), 'index.php?option=com_feedbackfactory&task=settings', ($vName == 'settings') ? true : false);
	JSubMenuHelper::addEntry( JText::_('COM_FEEDBACK_SUBMENU_ABOUT'), 'index.php?option=com_feedbackfactory&task=about', ($vName == 'about') ? true : false);
		
}
