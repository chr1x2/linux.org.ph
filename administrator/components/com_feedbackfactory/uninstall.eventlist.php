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
// Component uninstaller
function com_uninstall()
{
	$modules = array(
	  //array('name' => 'mod_menu',                 'title' => 'Feedback Menu'),
	  array('name' => 'mod_feedback_categories',      'title' => 'Feedback Categories'),
	  array('name' => 'mod_feedback_statuses',        'title' => 'Feedback Statuses'),
	);
	
	foreach ($modules as $module)
	{
	  uninstallModule($module);
	}
	
	// Languages
	$languages = array('en-GB');
	
	foreach ($modules as $module)
	{
	  foreach ($languages as $language)
	  {
	   	@unlink(JPATH_ROOT.DS.'language'.DS.$language.DS.$language.'.'.$module['name'].'.ini');
	  }
	}
	
	// Uninstall the menu
  	uninstallMenu();
}

function uninstallModule($module)
{
  recursive_remove_directory(JPATH_ROOT.DS.'modules'.DS.$module['name']);

  $database =& JFactory::getDBO();
  $query = ' SELECT id'
         . ' FROM #__modules'
         . ' WHERE module = "' . $module['name'] . '"';
  $database->setQuery($query);
  $id = $database->loadResult();

  if ($id)
  {
    $query = ' DELETE'
           . ' FROM #__modules'
           . ' WHERE id = ' . $id;
    $database->setQuery($query);
    $database->query();

    $query = ' DELETE'
           . ' FROM #__modules_menu'
           . ' WHERE moduleid = ' . $id;
    $database->setQuery($query);
    $database->query();
  }
  
  $query = ' SELECT extension_id'
         . ' FROM #__extensions'
         . ' WHERE name = "' . $module['name'] . '"';
  $database->setQuery($query);
  $ext_id = $database->loadResult();

  if ($ext_id)
  {
    $query = ' DELETE'
           . ' FROM #__extensions'
           . ' WHERE extension_id = ' . $ext_id;
    $database->setQuery($query);
    $database->query();

  
  }
  
}

function recursive_remove_directory($directory, $empty=FALSE)
{
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}
	if(!file_exists($directory) || !is_dir($directory))
	{
		return FALSE;
	}elseif(is_readable($directory))
	{
		$handle = opendir($directory);
		while (FALSE !== ($item = readdir($handle)))
		{
			if($item != '.' && $item != '..')
			{
				$path = $directory.'/'.$item;
				if(is_dir($path))
				{
					recursive_remove_directory($path);
				}else{
					unlink($path);
				}
			}
		}
		closedir($handle);
		if($empty == FALSE)
		{
			if(!rmdir($directory))
			{
				return FALSE;
			}
		}
	}
	return TRUE;
}

function uninstallMenu()
{
  $database =& JFactory::getDBO();

  // 1. Remove the menu
  $query = ' DELETE'
         . ' FROM #__menu_types'
         . ' WHERE menutype = "feedback"';
  $database->setQuery($query);
  $database->query();

  // 2. Remove the module
  $query = ' SELECT id'
         . ' FROM #__modules'
         . ' WHERE params LIKE "%feedback%"';
         
  $database->setQuery($query);
  $ids = $database->loadColumn();

  foreach ($ids as $id)
  {
    $query = ' DELETE'
           . ' FROM #__modules'
           . ' WHERE id = ' . $id;
           
    $database->setQuery($query);
    $database->query();

    $query = ' DELETE'
           . ' FROM #__modules_menu'
           . ' WHERE moduleid = ' . $id;
           
    $database->setQuery($query);
    $database->query();
  }

  // 3. Remove menu items
  $menu_items = array('index.php?option=com_feedbackfactory&task=feedbacks',
    'index.php?option=com_feedbackfactory&task=top',
    'index.php?option=com_feedbackfactory&task=mostcommented',
    'index.php?option=com_feedbackfactory&task=accepted',
    'index.php?option=com_feedbackfactory&task=completed',
    'index.php?option=com_feedbackfactory&task=addfeedback');
   
  $query = ' DELETE FROM #__menu'
         . ' WHERE link IN ("' . implode('", "', $menu_items) . '")';
  $database->setQuery($query);
  $database->query();
}
