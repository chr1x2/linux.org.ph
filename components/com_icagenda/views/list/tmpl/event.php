<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2013 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.1.5 2013-08-16
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

//Add Error Page
$js_event = "components/com_icagenda/add/js/jsevt.js";
if ($this->data->items == NULL) {
		JError::raiseError('404', '<div>&nbsp;</div><div class="hero-unit center"><h1>' . JTEXT::_('COM_ICAGENDA_PAGE_NOT_FOUND') . ' <small><font face="Tahoma" color="red">' . JTEXT::_('JERROR_ERROR') . ' 404</font></small></h1><br /><p>' . JTEXT::_('COM_ICAGENDA_REQUESTED_PAGE_NOT_FOUND') . ', ' . JTEXT::_('COM_ICAGENDA_CONTACT_THE_WEBMASTER_OR_TRY_AGAIN') . '. ' . JTEXT::_('COM_ICAGENDA_USE_YOUR_BROWSERS_BACK_BUTTON') . '</p><p><b>' . JTEXT::_('COM_ICAGENDA_OR_JUST_PRESS_BUTTON') . '</b></p><a href="index.php" class="btn btn-large btn-info button"><i class="icon-home icon-white"></i>&nbsp;' . JTEXT::_('JERROR_LAYOUT_HOME_PAGE') . '</a></div><div align="center"><img src="media/com_icagenda/images/iconicagenda48.png"></div>', '404');
		return false;
}
else {

?>
<!--
 * - - - - - - - - - - - - - -
 * iCagenda 3.1.13 by Jooml!C
 * - - - - - - - - - - - - - -
 * @copyright	Copyright (C) 2012-2013 JOOMLIC - All rights reserved.
 *
-->
<?php
	foreach ($this->data->items as $item){

		// prepare Document
		$document	= JFactory::getDocument();
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway 	= $app->getPathway();
		$title 		= null;

		$menu = $menus->getActive();
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $item->title));
		} else {
			$this->params->def('page_heading', JText::_('JGLOBAL_ARTICLES'));
		}

		$sitename = $app->getCfg('sitename');
		$title = $item->title;
		$description = $item->description;
		$thumbnail = $item->image;

		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
	if ($sitename) { $document->setMetadata('og:site_name', $sitename ); }
	if ($item->title) { $document->setTitle($item->title); }
	if ($item->desc) { $document->setDescription(strip_tags($item->description)); }
	if ($item->image) { $document->setMetadata('og:image', JURI::base().$item->image ); }

		// load Theme and css
?>
	<div id="icagenda<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php
//		JHTML::_('stylesheet', 'style.css', 'components/com_icagenda/add/css/');
		$document->addStyleSheet( JURI::base().'components/com_icagenda/add/css/style.css' );
		if(file_exists("components/com_icagenda/themes/packs/".$this->template."/".$this->template."_event.php")){
			$t_item = "components/com_icagenda/themes/packs/".$this->template."/".$this->template."_event.php";
//			JHTML::_('stylesheet', $this->template.'_component.css', 'components/com_icagenda/themes/packs/'.$this->template.'/css/');
			$document->addStyleSheet( JURI::base().'components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component.css' );
		}else{
			$t_item = "components/com_icagenda/themes/packs/default/default_event.php";
//			JHTML::_('stylesheet', 'default_component.css', 'components/com_icagenda/themes/packs/default/css/');
			$document->addStyleSheet( JURI::base().'components/com_icagenda/themes/packs/default/css/default_component.css' );
		}
		$stamp = $this->data;
		foreach ($this->data->items as $item){
			require_once $t_item;
		}
	}
}
require_once $js_event;
?>
</div>
