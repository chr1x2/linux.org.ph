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
 * @version     3.0 2013-05-31
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// iCagenda Class control (Joomla 2.5/3.x)
if(!class_exists('iCJView')) {
   if(version_compare(JVERSION,'3.0.0','ge')) {
      class iCJView extends JViewLegacy {
      };
   } else {
      jimport('joomla.application.component.view');
      class iCJView extends JView {};
   }
}

/**
 * HTML View class - iCagenda.
 */
class icagendaViewList extends iCJView
{
	protected $return_page;

	// Methode JView
	function display($tpl = null)
	{

		if(version_compare(JVERSION, '3.0', 'lt')) {

			JHTML::_('behavior.mootools');

			$document = JFactory::getDocument();

			// load jQuery, if not loaded before (NEW VERSION IN 1.2.6)
			$scripts = array_keys($document->_scripts);
			$scriptFound = false;
			$scriptuiFound = false;
			$mapsgooglescriptFound = false;
			for ($i = 0; $i < count($scripts); $i++) {
		    	if (stripos($scripts[$i], 'jquery.min.js') !== false) {
		     	   $scriptFound = true;
		    	}
				// load jQuery, if not loaded before as jquery - added in 1.2.7
		    	if (stripos($scripts[$i], 'jquery.js') !== false) {
		    	    $scriptFound = true;
		    	}
		    	if (stripos($scripts[$i], 'jquery-ui.min.js') !== false) {
		     	   $scriptuiFound = true;
		    	}
		    	if (stripos($scripts[$i], 'maps.google') !== false) {
		    	    $mapsgooglescriptFound = true;
		    	}
			}

			// jQuery Library Loader
			if (!$scriptFound) {
				// load jQuery, if not loaded before
				if (!JFactory::getApplication()->get('jquery')) {
					JFactory::getApplication()->set('jquery', true);
					// add jQuery
				    $document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
		    		$document->addScript('components/com_icagenda/js/jquery.noconflict.js');
				}
			}
			JHTML::script('http://maps.google.com/maps/api/js?sensor=false');
			if (!$scriptuiFound) {
		    	$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
			}

			$document->addScript( 'components/com_icagenda/js/icmap.js' );

		}
		else {

			jimport( 'joomla.environment.request' );

        	$document = JFactory::getDocument();

			JHtml::_('behavior.formvalidation');
			JHtml::_('bootstrap.framework');
			JHtml::_('jquery.framework');

			$document->addScript('http://maps.google.com/maps/api/js?sensor=false');
			$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
	      	$document->addScript( JURI::base().'components/com_icagenda/js/icmap.js' );
		}



		// loading data
		$this->data = $this->get('Data');

		// loading params
		$app = JFactory::getApplication();
		$icpar = $app->getParams();


		$this->template = $icpar->get('template');
		$this->title = $icpar->get('title');
		$this->format = $icpar->get('format');
		$this->copy = $icpar->get('copy');
		$this->atlist = $icpar->get('atlist');
//		$this->atevent = $icpar->get('atevent');
		$this->addthis = $icpar->get('addthis');
		$this->atfloat = $icpar->get('atfloat');
		$this->aticon = $icpar->get('aticon');
		$this->limit = $icpar->get('limit');

		$this->time = $icpar->get('time');
		$this->navposition = $icpar->get('navposition');
		$this->targetLink = $icpar->get('targetLink');

		$this->regEmailUser = $icpar->get('regEmailUser');
		$this->emailUserSubjectPeriod = $icpar->get('emailUserSubjectPeriod');
		$this->emailUserBodyPeriod = $icpar->get('emailUserBodyPeriod');
		$this->emailUserSubjectDate = $icpar->get('emailUserSubjectDate');
		$this->emailUserBodyDate = $icpar->get('emailUserBodyDate');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// ASSIGN
		$this->assignRef('params',		$icpar);

		$this->_prepareDocument();

		parent::display($tpl);
	}

	protected function _prepareDocument() {

		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway 	= $app->getPathway();
		$title 		= null;


		$menu = $menus->getActive();
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('JGLOBAL_ARTICLES'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description', '')) {
			$this->document->setDescription($this->params->get('menu-meta_description', ''));
		}

		if ($this->params->get('menu-meta_keywords', '')) {
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords', ''));
		}

		if ($app->getCfg('MetaTitle') == '1' && $this->params->get('menupage_title', '')) {
			$this->document->setMetaData('title', $this->params->get('page_title', ''));
		}


	}
}
