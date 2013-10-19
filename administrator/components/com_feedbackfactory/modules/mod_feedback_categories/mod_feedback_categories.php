<?php
/*------------------------------------------------------------------------
mod_feedback_categories - Feedback Factory 2.0.0
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

$database = JFactory::getDbo();

// Integration check
$extension = JTable::getInstance('extension');
$db_check = $extension->find(array('type' => 'component', 'element' => 'com_feedbackfactory'));

if (!$db_check)
{
  require( dirname( __FILE__ ).DS.'tmpl'.DS.'error.php' );
}
else
{
    require_once (JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_feedbackfactory'.DS.'lib'.DS.'helpers'.DS.'feedbackHelper.class.php');
    $Itemid = feedbackHelper::getMenuItemByTaskName(array("task"=>"feedbacks"));

  $database = JFactory::getDBO();

  $query = ' SELECT c.*'
         . ' FROM #__feedback_categories c'
         . ' WHERE c.published = 1';
  $database->setQuery($query);
  $categories = $database->loadObjectList();

  require( dirname( __FILE__ ).DS.'tmpl'.DS.'default.php' );
}
