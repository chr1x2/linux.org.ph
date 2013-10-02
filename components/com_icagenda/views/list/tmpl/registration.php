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
 * @version     3.1.7 2013-08-28
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

if ($this->data->items == NULL) {
		JError::raiseError('404', '<div>&nbsp;</div><div class="hero-unit center"><h1>' . JTEXT::_('COM_ICAGENDA_PAGE_NOT_FOUND') . ' <small><font face="Tahoma" color="red">' . JTEXT::_('JERROR_ERROR') . ' 404</font></small></h1><br /><p>' . JTEXT::_('COM_ICAGENDA_REQUESTED_PAGE_NOT_FOUND') . ', ' . JTEXT::_('COM_ICAGENDA_CONTACT_THE_WEBMASTER_OR_TRY_AGAIN') . '. ' . JTEXT::_('COM_ICAGENDA_USE_YOUR_BROWSERS_BACK_BUTTON') . '</p><p><b>' . JTEXT::_('COM_ICAGENDA_OR_JUST_PRESS_BUTTON') . '</b></p><a href="index.php" class="btn btn-large btn-info button"><i class="icon-home icon-white"></i>&nbsp;' . JTEXT::_('JERROR_LAYOUT_HOME_PAGE') . '</a></div><div align="center"><img src="media/com_icagenda/images/iconicagenda48.png"></div>', '404');
		return false;
}

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

	$title = JText::_( 'COM_ICAGENDA_REGISTRATION_TITLE' ).' : '.$item->title;

	if (empty($title)) {
		$title = $app->getCfg('sitename');
	}
	elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
		$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
	}
	elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
		$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
	}
	$document->setTitle($title);

	// load Theme and css
?>
<div id="icagenda<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
<?php
	if(file_exists("components/com_icagenda/themes/packs/".$this->template."/".$this->template."_list.php")){
		$t_registration = "components/com_icagenda/themes/packs/".$this->template."/".$this->template."_registration.php";
//		JHTML::_('stylesheet', $this->template.'_component.css', 'components/com_icagenda/themes/packs/'.$this->template.'/css/');
		$document->addStyleSheet( JURI::base().'components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component.css' );
	}else{
		$t_registration = "components/com_icagenda/themes/packs/default/default_registration.php";
//		JHTML::_('stylesheet', 'default_component.css', 'components/com_icagenda/themes/packs/default/css/');
		$document->addStyleSheet( JURI::base().'components/com_icagenda/themes/packs/default/css/default_component.css' );
	}
}

?>
<!--
 * - - - - - - - - - - - - - -
 * iCagenda 3.1.13 by Jooml!C
 * - - - - - - - - - - - - - -
 * @copyright	Copyright (C) 2012-2013 JOOMLIC - All rights reserved.
 *
-->
<?php


$stamp = $this->data;
require_once $t_registration;

$user = JFactory::getUser();
$u_id=$user->get('id');
$u_mail=$user->get('email');

// logged-in Users: Name/User Name Option
$nameJoomlaUser = JComponentHelper::getParams('com_icagenda')->get('nameJoomlaUser', 1);
if ($nameJoomlaUser == 1) {
	$u_name=$user->get('name');
} else {
	$u_name=$user->get('username');
}

// Autofill name and email if registered user log in
$autofilluser = JComponentHelper::getParams('com_icagenda')->get('autofilluser', 1);
if ($autofilluser != 1) {
	$u_name='';
	$u_mail='';
}

// Get Phone Options
$phoneDisplay = JComponentHelper::getParams('com_icagenda')->get('phoneDisplay', 1);

// Get Notes Options
$notesDisplay = JComponentHelper::getParams('com_icagenda')->get('notesDisplay', 0);

//$themeform = $this->template.'_form';
$theme = $this->template;

//$infoimg = JURI::root().'components/com_icagenda/themes/packs/'.$theme.'/images/info.png';
$infoimg = JURI::root().'components/com_icagenda/themes/packs/default/images/info.png';
?>

<div>
<div class="formTitle">
<h2><?php echo JText::_( 'COM_ICAGENDA_REGISTRATION_TITLE' ); ?></h2>
</div>
	<form name="registration" action="<?php echo JRoute::_('index.php'); ?>"  class="icagenda_form" method="post" class="form-validate">
	<div class="fieldset">
		<div>
			<div>
				<?php if (($u_id) AND ($autofilluser==1)){
					echo '<label>'.JText::_( 'ICAGENDA_REGISTRATION_FORM_USERID' ).'</label>
						  <input type="text" value="'.$u_id.'" disabled="disabled" size="2" />
						  <input type="hidden" name="uid" value="'.$u_id.'" />';
				}else{
					echo '<input type="hidden" name="uid" value="" disabled="disabled" size="2" />';
				}?>
				<?php if (($u_id) AND ($autofilluser==1)){ ?>
				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_USERID' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_USERID_DESC' ); ?></div>
					</span>
					</a>
				</span>
				<?php } ?>
   			</div>
			<div>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NAME' ); ?> *</label>
				<?php if ($u_mail){
					echo '<input type="text" value="'.$u_name.'" disabled="disabled" />
						  <input type="hidden" name="name" value="'.$u_name.'" />';
				}else{
					echo '<input type="text" name="name" value="" size="30" required="true" />';
				}?>
				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NAME' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NAME_DESC' ); ?></div>
					</span>
					</a>
				</span>
   			</div>
			<div>
			<?php if ($item->emailRequired == '1') { ?>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_EMAIL' ); ?> *</label>
				<?php if ($u_name){
					echo '<input type="email" value="'.$u_mail.'" disabled="disabled" />
						  <input type="hidden" name="email" value="'.$u_mail.'" />';
				}else{
					echo '<input type="email" name="email" value="" size="30" required="true" class="required validate-email" />';
				}?>
			<?php } else { ?>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_EMAIL' ); ?></label>
				<?php if ($u_name){
					echo '<input type="email" value="'.$u_mail.'" disabled="disabled" />
						  <input type="hidden" name="email" value="'.$u_mail.'" />';
				}else{
					echo '<input type="email" name="email" value="" size="30" class="required validate-email" />';
				}?>
			<?php } ?>

        		<!--span class="formInfo" ><?php echo JHTML::tooltip(JText::_( 'ICAGENDA_REGISTRATION_FORM_EMAIL_DESC' ), JText::_( 'ICAGENDA_REGISTRATION_FORM_EMAIL' ),
               JURI::root().'components/com_icagenda/themes/packs/'.$theme.'/images/info.png', '', '', false); ?></span-->
				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_EMAIL' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_EMAIL_DESC' ); ?></div>
					</span>
					</a>
				</span>
			</div>
			<div>
			<?php if ($item->phoneRequired == '1'): ?>
				<?php if ($phoneDisplay == 1) : ?>
					<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PHONE' ); ?> *</label>
					<input type="text" name="phone" size="20" required="true" />
				<?php endif; ?>
			<?php endif; ?>
			<?php if (($item->phoneRequired == '0') OR ($item->phoneRequired == '2')): ?>
				<?php if ($phoneDisplay == 1) : ?>
					<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PHONE' ); ?></label>
					<input type="text" name="phone" size="20" />
				<?php endif; ?>
			<?php endif; ?>


				<!--span class="formInfo" ><?php echo JHTML::tooltip(JText::_( 'ICAGENDA_REGISTRATION_FORM_PHONE_DESC' ), JText::_( 'ICAGENDA_REGISTRATION_FORM_PHONE' ),
               JURI::root().'components/com_icagenda/themes/packs/'.$theme.'/images/info.png', '', '', false); ?></span>

               <span class="formInfo"><img src="<?php echo $infoimg; ?>" /><ictip><b><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NAME' ); ?></b><p><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NAME_DESC' ); ?></p></ictip></span-->

				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PHONE' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PHONE_DESC' ); ?></div>
					</span>
					</a>
				</span>
			</div>


			<?php
			foreach($stamp->items as $item){
				$typeReg = $item->typeReg;


//
// Toutes Options
//

	if ($typeReg == 0) {
			?>
			<div>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE' ); ?></label>
				<select type="hidden" name="date">
					<?php
					foreach($stamp->items as $item){
						foreach($item->datelistMkt as $date){
//							$today=time();
//							$dateT=mktime($date);
//							if ($dateT > $today) {
								echo '<option value="'.$date.'">'.$date.'</option>';
//							}
						}
					}
					?>
				<select>
				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE_DESC' ); ?></div>
					</span>
					</a>
				</span>
			</div>
			<?php if ($item->periodDisplay): ?>
				<?php if ($item->periodControl == 1): ?>
				<div>
					<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PERIOD' ); ?></label>
						<?php
						foreach($stamp->items as $item){
							$start = $item->startDate.' <span class="evttime">'.$item->startTime.'</span>';
							$end = $item->endDate.' <span class="evttime">'.$item->endTime.'</span>';
							echo $start.' - '.$end;
						}
						?>
						</div>
						<div>
					<label>&nbsp;</label>
					<?php echo JText::_( 'JYES' );?> <input type="radio" name="period" value="1" />
					<?php echo JText::_( 'JNO' );?> <input type="radio" name="period" value="0" CHECKED />
					<span class="formInfo">
						<a class="ictip"><img src="<?php echo $infoimg; ?>" />
						<span>
							<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PERIOD' ); ?></span>
							<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PERIOD_DESC' ); ?></div>
						</span>
						</a>
					</span>
				</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php


//
// Liste Dates
//
				} elseif ($typeReg == 1) {
			?>
			<div>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE' ); ?></label>
				<select type="hidden" name="date">
					<?php
					foreach($stamp->items as $item){
						foreach($item->datelistMkt as $date){
//							$today=time();
//							$dateT=mktime($date);
//							if ($dateT > $today) {
								echo '<option value="'.$date.'">'.$date.'</option>';
//							}
						}
					}
					?>
				<select>
				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE_DESC' ); ?></div>
					</span>
					</a>
				</span>
			</div>

			<?php


//
// Periode uniquement
//
				} else {
					?>
			<?php if ($item->periodDisplay): ?>
				<?php if ($item->periodControl == 1): ?>
					<div>
						<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PERIOD' ); ?></label>
							<input type="hidden" name="period" value="1" />
							<?php
							foreach($stamp->items as $item){
								$start = $item->startDate.' <span class="evttime">'.$item->startTime.'</span>';
								$end = $item->endDate.' <span class="evttime">'.$item->endTime.'</span>';
								echo $start.' - '.$end;
							}
							?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if (!$item->periodDisplay): ?>
			<div>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE' ); ?></label>
				<select type="hidden" name="date">
					<?php
					foreach($stamp->items as $item){
						foreach($item->datelistMkt as $date){
//							$today=time();
//							$dateT=mktime($date);
//							if ($dateT > $today) {
								echo '<option value="'.$date.'">'.$date.'</option>';
//							}
						}
					}
					?>
				<select>
				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_DATE_DESC' ); ?></div>
					</span>
					</a>
				</span>
			</div>
			<?php endif; ?>
			<?php
				}

			}


					foreach($stamp->items as $item){
						$maxRlist = $item->maxRlist;
						if ($maxRlist > 1) {

			?>



			<div>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PEOPLE' ); ?></label>
				<select type="list" name="people">
					<?php
						$maxRlist = $item->maxRlist;
						$maxReg = $item->maxReg;
						$registered = $item->registered;
						$placeRemain = ($maxReg - $registered);
						if ($placeRemain < $maxRlist) {
							$maxRlist = $placeRemain;
						}
						for ($i=1; $i <= $maxRlist; $i++) {
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PEOPLE' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_PEOPLE_DESC' ); ?></div>
					</span>
					</a>
				</span>
			</div>

			<?php
				} else {
			?>
				<input type="hidden" name="people" value="1" />


			<?php
				}

			}


			?>


			<?php if ($notesDisplay == 1) : ?>
			<div>
				<label><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NOTES' ); ?></label>
				<TEXTAREA name="notes" rows="10" cols="5" style="width:100%" placeholder="<?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NOTES_DESC' ); ?>"></TEXTAREA>
				<!--span class="formInfo">
					<a class="ictip"><img src="<?php echo $infoimg; ?>" />
					<span>
						<span class="title"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NOTES' ); ?></span>
						<div class="text"><?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_NOTES_DESC' ); ?></div>
					</span>
					</a>
				</span-->
			</div>
			<?php endif; ?>


			<div>
				<input type="hidden" name="event" value="<?php echo JRequest::getInt('id'); ?>" />
			</div>
			<div>
				<input type="hidden" name="menuID" value="<?php echo JRequest::getInt('Itemid'); ?>" />
			</div>
		</div>
			<div class="bgButton">
				<span>
				<input type="submit" value="<?php echo JText::_( 'ICAGENDA_REGISTRATION_FORM_SUBMIT' ); ?>" class="button" name="Submit"/>
					<input type="hidden" name="return" value="index.php" />
					<?php
					echo JHtml::_( 'form.token' ); ?>
				</span>
				<span class="buttonx">
					<a href="javascript:history.go(-1)" title="<?php echo JTEXT::_('COM_ICAGENDA_CANCEL'); ?>">
				<?php echo JTEXT::_('COM_ICAGENDA_CANCEL'); ?>
				</a>
				</span>
			</div>
	</div>
	<div class="clr"></div>
	</form>
</div>
</div>
