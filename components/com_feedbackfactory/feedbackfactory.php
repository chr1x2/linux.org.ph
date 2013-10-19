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

$user = JFactory::getUser();

require_once (JPATH_COMPONENT.DS.'controller.php');
$app = JFactory::getApplication();
if ($controller = $app->input->getCmd('controller'))
{
	require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

$classname = 'FrontendController'.$controller;
$controller = new $classname();

$task = $app->input->getCmd('task', '');
$view = $app->input->getCmd('view');

if ('' == $task)
    $task = '' == $view ? $app->input->getCmd('layout') : $view;

$views = array( 'comments', 'addfeedback');
if (in_array($app->input->getString('view', ''), $views)){
    $task = '';
}

$controller->execute($task);
$controller->redirect();
