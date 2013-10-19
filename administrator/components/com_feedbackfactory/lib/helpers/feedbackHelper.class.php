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

class feedbackHelper
{

  static function getInstance()
  {
    static $instance;

    if (!isset($instance))
    {
      $instance = new feedbackHelper();
    }

    return $instance;
  }
  
  static function getDefaultStatuses()
  {
  	$database = JFactory::getDbo();

    $query = ' SELECT id'
           . ' FROM #__feedback_statuses'
           . ' WHERE  LENGTH(`default_status`) > 0';
    $database->setQuery($query);
    
    return $database->loadColumn();
  }

  static function getStatusId($default_status)
  {
  	$database = JFactory::getDbo();
  	$query = ' SELECT id '
  		. ' FROM #__feedback_statuses '
  		. ' WHERE `default_status` = "'.$default_status.'" ';
  		
  	$database->setQuery($query);
  	return $database->loadResult();
  }
 
 
  static function checkUniqueName($title)
  {
    $title = JFilterOutput::cleanText($title);
    $database = JFactory::getDbo();
    
    $query = ' SELECT f.id'
        . ' FROM #__feedback_feedbacks f'
        . ' WHERE f.title = "' . $title . '"';
        
    $database->setQuery($query, 0, 1);
    $checked_id = $database->loadResult();

    if (!$checked_id)
       return true;
    else 
    	return false;
  }
	
  
  static function trimText($text, $length = 100)
  {
    if (strlen($text) > $length)
    {
      return substr($text, 0, $length) . '...';
    }

    return $text;
  }

  function formatDate($date, $format = 'n')
  {
    switch ($format)
    {
      case 'n':
        return date('d.m.y, H:i', strtotime($date));
      break;
    }
  }

  static function feedbackDate($date)
  {
    $output = '<div class="feedbackfactory-calendar">'
            . '  <div class="feedbackfactory-day-name">' . date('D', JText::_(strtotime($date))) . '</div>'
            . '  <div class="feedbackfactory-day">' . date('d', strtotime($date)) . '</div>'
            . '  <div class="feedbackfactory-month">' . Jtext::_(date('M', strtotime($date))) . '</div>'
            . '  <div class="feedbackfactory-year">' . date('Y', strtotime($date)) . '</div>'
            . '</div>';
    return $output;
  }

  static function checkGuestView($force_redirect = null)
  {
    $app = JFactory::getApplication();
    $Itemid   = $app->input->getInt('Itemid',0);
    $option    = $app->input->getCmd('option', '');

    $user = JFactory::getUser();
    $settings = new feedbackSettings();

    if (!$settings->allow_guest_write && $user->guest) {
	    if ((!$settings->enable_guest_view || $force_redirect) && $user->guest)
	    {
	      $session =& JFactory::getSession();
	      $session->set('referer', $_SERVER['REQUEST_URI']);
		  
	      $uri     = JUri::getInstance();
	      $app->redirect('index.php?option=com_users&view=login&return=' . base64_encode($uri), JText::_('You need to login to access this page'));
	      
	    }
    }
  }
 
  function checkIsLoggedIn()
  {
      $app = JFactory::getApplication();
      $Itemid   = $app->input->getInt('Itemid',0);
      $option    = $app->input->getCmd('option', '');

    $user = JFactory::getUser();

    if ($user->guest)
    {
      $session =& JFactory::getSession();
      $session->set('referer', $_SERVER['REQUEST_URI']);

      $app->redirect(JRoute::_('index.php?option=com_feedbackfactory&view=login&Itemid=' . $Itemid, false));
    }
  }

  static function addScriptDeclarations($declarations)
  {
    $doc = JFactory::getDocument();

    foreach ($declarations as $var => $val)
    {
      $content = 'var ' . $var . ' = ';

      if (is_numeric($val))
      {
        $content .= $val;
      }
      elseif (is_array($val))
      {
        $content .= 'new Array("' . implode('", "', $val) . '")';
      }
      else
      {
        $content .= '"' . $val . '"';
      }

      $content .= ';';

      $doc->addScriptDeclaration($content);
    }
  }

  static function stripJavascript($document)
  {
    $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                    '@<iframe[^>]*?>.*?</iframe>@si',  // Strip out iframes
                    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
    );

    $text = preg_replace($search, '', $document);

    $aDisabledAttributes = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $text = preg_replace('/<(.*?)>/ie', "'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $aDisabledAttributes) . ")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", $text);

    return $text;
  }

  function isAdmin()
  {
    $user = JFactory::getUser();
    return $user->authorise('core.login.admin');
  }

  static function getCBIntegration()
  {
    $database = JFactory::getDBO();

    $query = ' SELECT COUNT(*)'
           . ' FROM #__extensions'
           . ' WHERE `type`="component" AND `element`="com_comprofiler" ';
    $database->setQuery($query);

    if($database->loadResult() > 0) {
        define('CB_DETECT',1);
    } else {
        define('CB_DETECT',0);
    }

    return $database->loadResult();
  }

  function detectCBPlugin($pluginname)
  {
    $extension = JTable::getInstance('extension');
    $cb_plugin_exists = $extension->find(array('type' => 'component', 'element' => 'com_comprofiler'));

    if ( !$cb_plugin_exists )
		return false;
	else {
		$database = JFactory::getDbo();

	    $query = "SELECT id FROM #__comprofiler_plugin where element='$pluginname.plugin'";
	   	$database->setQuery($query);
	    $plugid = $database->loadResult();

	    if($database->loadResult() > 0){
	    	return true;
	    } else {
	    	return false;
	    }
    }
  }


  static function getAvatar($user_id, $avatar_type)
  {
    $src = false;
    $database = JFactory::getDBO();
    $settings = new feedbackSettings();
    //$avatar_type = 'cb'
    /*if (!$user_id)
    {
      $avatar_type = 3;
    }*/

    switch ($avatar_type)
    {
      // Use own avatar
      case 2:
        //$src = JURI::root() . 'components/com_feedbackfactory/storage/users/' . $user_id . '/avatar/avatar.' . $avatar_extension . '?' . time() . $user_id;
      break;

      // CB avatar
      case 'cb':
       /* $settings = new wallSettings();

        if (!$settings->enable_cbavatar)
        {
          break;
        }*/

        $query	=	"SELECT u.name,u.email,u.username,c.avatar,c.avatarapproved, u.id " . "\n
            FROM #__comprofiler AS c" . "\n
                LEFT JOIN #__users AS u ON c.id=u.id" . "\n
                WHERE c.id = $user_id" . "\n
                AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0";
        $database->setQuery($query);

        $user_profile = $database->loadAssoc();
        if (isset($user_profile['avatar'])){
            $size = max(array($settings->avatar_max_width, $settings->avatar_max_height));
            $src = JURI::root() . 'images/comprofiler/' . $user_profile['avatar'];
            //$src = 'http://www.gravatar.com/avatar/'.$email.'?s='.$size.'.jpg';
        }
      break;
    }
    return $src ? '<img class="cbFullPict" title="'.$user_profile["username"].'" alt="'.$user_profile["username"].'" src="' . $src . '" width="' .$size. '" />' : false;
  }

  function adminCBInstall(){

      $install_file = JPATH_COMPONENT_SITE. DS. 'installer'. DS. 'cbplugin.php';
      require_once($install_file);

      com_feedbackfactoryPluginInstallerScript::install_cbplugin('feedback_factory');


      /*$install_file = JPATH_COMPONENT_ADMINISTRATOR.DS."install.eventlist.php";;
	    require_once($install_file);

    com_feedbackPluginInstallerScript::install_cbplugin('feedback_factory');*/

    return true;
  }

  static function getMenuItemByTaskName($task_name){
    if (is_array($task_name)){
        $task_name = $task_name['task'];
    }

    $database = JFactory::getDbo();
    $database->setQuery("SELECT id FROM #__menu WHERE link LIKE '%task=$task_name%' OR '%layout=$task_name%' ORDER BY id DESC LIMIT 0 , 1 ");

    return $database->loadResult();
  }

  public static function getMenuItemId($needles)
  {

    if (!is_array($needles)) {
        if ($needles)
            $needles = array($needles);
        else
            $needles = array();
    }

    $needles['option'] = 'com_feedbackfactory';
    $jApp = JApplication::getInstance('site');
    $menus = $jApp->getMenu('site', array());

    $items = $menus->getItems('query', $needles);

    if (!count($items))
        return null; //no extension menu items

    $match = reset($items); //fallback first encountered Menuitem

    foreach ($items as $item) {
        if ($match->access != 0 && $item->access == 0) {
            $match = $item; //even better fallback is one that has public access
            continue;
        }

        $xssmatch1 = array_intersect_assoc($item->query, $needles);
        $xssmatch2 = array_intersect_assoc($match->query, $needles);
        //var_dump($xssmatch1, $xssmatch2);
        if (count($xssmatch1) > count($xssmatch2)) { //better needlematch
            $match = $item; //even better fallback is one that has public access
            continue;
        }
    }

    return $match->id;
  }


}
