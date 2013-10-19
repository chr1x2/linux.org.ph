<?php
defined('_JEXEC') or die('Restricted access');

/*------------------------------------------------------------------------
com_wallfactory - Wall Factory 3.0.0
------------------------------------------------------------------------
author    TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support:  Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

jimport('joomla.application.component.model');

class BackendModelAbout extends JModelLegacy
{
  function __construct()
  {
    parent::__construct();
  }

  function getVersion()
  {
    $file = JPATH_COMPONENT_ADMINISTRATOR.DS.'com_feedback.xml';
    $data = JApplicationHelper::parseXMLInstallFile($file);

    return $data['version'];
  }

  function getInformation()
  {
    require_once(JPATH_ROOT.DS.'libraries'.DS.'domit'.DS.'xml_domit_lite_parser.php');
    $xmldoc = new DOMIT_Lite_Document();
    @set_time_limit(60);

    $filename     = 'http://thefactory.ro/versions/com_feedback.xml';
    $fileContents = @$this->remote_read_url($filename);

    if (!$fileContents)
    {
      require_once(JPATH_ROOT.DS.'libraries'.DS.'domit'.DS.'php_file_utilities.php');
      $fileContents =& php_file_utilities::getDataFromFile($filename, 'r');
    }
    if (!$fileContents)
    {
      return false;
    }

    $success = $xmldoc->parseXML($fileContents);

    if (!$success)
    {
      return false;
    }

    $information = array();

    $element = &$xmldoc->getElementsByPath('/version_info/latestversion', 1);
    $information['latestversion'] = $element ? $element->getText() : '';

    $element = &$xmldoc->getElementsByPath('/version_info/downloadlink', 1);
    $information['downloadlink'] = $element ? $element->getText() : '';

    $element = &$xmldoc->getElementsByPath('/version_info/newdownloadlink', 1);
    $information['newdownloadlink'] =$element ? $element->getText() : '';

    $element = &$xmldoc->getElementsByPath('/version_info/newsletter', 1);
    $information['newsletter'] = $element ? $element->getText() : '';

    $element = &$xmldoc->getElementsByPath('/version_info/announcements', 1);
    $information['announcements'] = $element ? $element->getText() : '';

    $element = &$xmldoc->getElementsByPath('/version_info/notes', 1);
    $information['releasenotes'] = $element ? $element->getText() : '';

    return $information;
  }

  function remote_read_url($uri)
  {
    if (function_exists('curl_init'))
    {
      $handle = curl_init();

      curl_setopt ($handle, CURLOPT_URL, $uri);
      curl_setopt ($handle, CURLOPT_MAXREDIRS,5);
      curl_setopt ($handle, CURLOPT_AUTOREFERER, 1);
      curl_setopt ($handle, CURLOPT_FOLLOWLOCATION ,1);
      curl_setopt ($handle, CURLOPT_CONNECTTIMEOUT, 10);
      curl_setopt ($handle, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($handle, CURLOPT_TIMEOUT, 10);

      $buffer = @curl_exec($handle);

      curl_close($handle);
      return $buffer;
    }
    elseif (ini_get('allow_url_fopen'))
    {
      $fp = @fopen($uri, 'r');

      if (!$fp)
      {
        return false;
      }

      stream_set_timeout($fp, 20);
      $linea = '';
      while ($remote_read = fread($fp, 4096))
      {
        $linea .= $remote_read;
      }

      $info = stream_get_meta_data($fp);
      fclose($fp);

      if ($info['timed_out'])
      {
        return false;
      }

      return $linea;
    }
    else
    {
      return false;
    }
  }


}