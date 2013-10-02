<?php
/**
 *	iCagenda
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C) 2012-2013 JOOMLIC - All rights reserved.

 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 *
 * @since		1.0
 *----------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_cat extends JFormField
{
	protected $type='modal_cat';

	protected function getInput()
	{

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.title, a.state, a.id')
			->from('`#__icagenda_category` AS a');
		$db->setQuery($query);
		$cat = $db->loadObjectList();
		$class = JRequest::getVar('class');

		$html= '
			<select id="'.$this->id.'_id"'.$class.' name="'.$this->name.'">';
		if ($this->name!='jform[catid]' && $this->name!='catid') $html.='<option value="0">'.JTEXT::_('COM_ICAGENDA_ALL_F').'</option>';
		foreach ($cat as $c){
		if ($c->state == '1') {
			$html.='<option value="'.$c->id.'"';
			if ($this->value == $c->id){
				$html.='selected="selected"';
			}
			$html.='>'.$c->title.'</option>';
		}
		}
		$html.='</select>';
		return $html;

	}
}
