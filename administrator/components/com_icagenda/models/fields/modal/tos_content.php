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
 * @version     3.2.0 2013-09-12
 * @since       3.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_tos_content extends JFormField
{
	protected $type='modal_tos_content';

	protected function getInput()
	{
		$class = JRequest::getVar('class');

		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');
		$tosContent = $icagendaParams->get('tosContent');

		if (!isset($tosContent)) { $tosContent = JText::_( 'COM_ICAGENDA_TOS'); }

		//$html ='<input type="editor" id="'.$this->id.'" class="'.$class.'" name="'.$this->name.'" value="'.$this->value.'" placeholder="'.$extRegButtonText.'"/>';

		$editor = JFactory::getEditor(null);

		$html = $editor->display("tosContent", $tosContent, "400", "100", "150", "10", 1, null, null, null, array('mode' => 'advanced'));

		return $html;
	}
}
