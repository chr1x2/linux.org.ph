<?php
/*------------------------------------------------------------------------
com_wallfactory - Wall Factory 3.0.0
------------------------------------------------------------------------
author    TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support:  Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pane');

class BackendViewAbout extends JViewLegacy
{
  function display($tpl = null)
  {
    JToolBarHelper::title(JText::_('About'), 'generic.png');

      $filename = 'http://thefactory.ro/versions/com_feedbackfactory.xml';
      $model    =& JModelLegacy::getInstance('About', 'BackendModel');
      $doc = $model->remote_read_url($filename);

      $class = 'SimpleXMLElement';
      if (class_exists('JXMLElement'))
      {
          $class = 'JXMLElement';
      }

      if (is_file($doc))
      {
        // Try to load the XML file
        $xml = simplexml_load_file($doc, $class);
      }
      else
      {
        // Try to load the XML string
        $xml = simplexml_load_string($doc, $class);
      }

      if (!$xml) {
        throw new Exception(JText::_('JERROR_LOADFILE_FAILED'));
      }

      $this->assign('isnew_version', !(version_compare(COMPONENT_VERSION, (string)$xml->latestversion)>=0));
      $this->assign('latestversion', (string)$xml->latestversion);
      $this->assign('versionhistory', (string)$xml->versionhistory);
      $this->assign('downloadlink', (string)$xml->downloadlink);
      $this->assign('aboutfactory', html_entity_decode((string)$xml->aboutfactory));
      $this->assign('otherproducts', html_entity_decode((string)$xml->otherproducts));
      $this->assign('build', (string)$xml->build);

      parent::display($tpl);
  }
}
