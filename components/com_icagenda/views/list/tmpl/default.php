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

?>
<!--
 * - - - - - - - - - - - - - -
 * iCagenda 3.1.13 by Jooml!C
 * - - - - - - - - - - - - - -
 * @copyright	Copyright (C) 2012-2013 JOOMLIC - All rights reserved.
 *
-->
<?php


//
// Old function for template 1.2.x.
//
function convertColor($color){
	#convert hexadecimal to RGB
	if(!is_array($color) && preg_match("/^[#]([0-9a-fA-F]{6})$/",$color)){
		$hex_R = substr($color,1,2);
		$hex_G = substr($color,3,2);
		$hex_B = substr($color,5,2);
		$RGB = hexdec($hex_R).",".hexdec($hex_G).",".hexdec($hex_B);
		return $RGB;
	}

	#convert RGB to hexadecimal
	else{
		if(!is_array($color)){$color = explode(",",$color);}

		foreach($color as $value){
			$hex_value = dechex($value);
			if(strlen($hex_value)<2){$hex_value="0".$hex_value;}
			$hex_RGB='';
			$hex_RGB.=$hex_value;
		}
		return "#".$hex_RGB;
	}

}

$RGB='$RGB';
$RGBa=$RGB[0];
$RGBb=$RGB[1];
$RGBc=$RGB[2];
$item_color = '';
if (isset($item->cat_color)) {$item_color = $item->cat_color;}
$js_list = "components/com_icagenda/add/js/jsevt.js";
$RGB = explode(",",convertColor($item_color)); $a = array($RGBa, $RGBa, $RGBa);
$somme = array_sum($a);

if (isset($this->navposition)) {$navposition = $this->navposition;} else {$navposition = '0';}
//
// End old function

// Header
?>
<div id="icagenda<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="componentheading">
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
<?php
if(isset($this->data)) $stamp = $this->data;
if($stamp->container->header){
	echo '<div>';
	echo $stamp->container->header;
	if ($navposition == '0') {
		echo $stamp->container->navigator;
	}
	echo '</div>';
}
$stampitems = $stamp->items;
$someObjectArr = (array)$stampitems;
$control = empty($someObjectArr);

$document	= JFactory::getDocument();
//	JHTML::_('stylesheet', 'style.css', 'components/com_icagenda/add/css/');
$document->addStyleSheet( JURI::base().'components/com_icagenda/add/css/style.css' );

if(!$control){
	if(file_exists("components/com_icagenda/themes/packs/".$this->template."/".$this->template."_list.php")){
		$t_list = "components/com_icagenda/themes/packs/".$this->template."/".$this->template."_list.php";
//		JHTML::_('stylesheet', $this->template.'_component.css', 'components/com_icagenda/themes/packs/'.$this->template.'/css/');
		$document->addStyleSheet( JURI::base().'components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component.css' );
	}else{
		$t_list = "components/com_icagenda/themes/packs/default/default_list.php";
//		JHTML::_('stylesheet', 'default_component.css', 'components/com_icagenda/themes/packs/default/css/');
		$document->addStyleSheet( JURI::base().'components/com_icagenda/themes/packs/default/css/default_component.css' );
	}
	require_once $t_list;
}
// Navigator
if($stamp->container->navigator){
echo '<div>';
	if ($navposition == '1') {
		echo $stamp->container->navigator;
	}
	echo '</div>';
}
require_once $js_list;

?>
</div>

